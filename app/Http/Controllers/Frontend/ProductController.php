<?php

namespace App\Http\Controllers\Frontend;

use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Jobs\PostViewJob;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ColorRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SearchKeyRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{


    public function index(Request $request, $category = null)
    {
        // Store search key only when actual search parameters exist
        if ($request->query()) {
            SearchKeyRepository::storeOrUpdate($request);
        }

        $products = SellingPostRepository::filterProducts($request, $category)
            ->paginate(9)
            ->withQueryString();

        $conditions = SellingPostRepository::query()
            ->selectRaw('conditions, COUNT(*) as total')
            ->whereNotNull('conditions')
            ->where('conditions', '!=', '')
            ->groupBy('conditions')
            ->orderBy('conditions')
            ->get();
        $locations = SellingPostRepository::getLocationsWithCount();
        $brands = SellingPostRepository::getBrandsWithCount();
        $DateFilters = SellingPostRepository::getDateFiltersWithCount();
        $allCategories = CategoryRepository::getAll();


        return \Inertia\Inertia::render('Feed', [
            'products' => $products,
            'conditions' => $conditions,
            'locations' => $locations,
            'brands' => $brands,
            'DateFilters' => $DateFilters,
            'allCategories' => $allCategories,
            'filters' => request()->all(),
        ]);
    }

    public function show($id)
    {
        $product = SellingPostRepository::query()->findOrFail($id);

        $location_name = $product->location;
        if ($product->latitude && $product->longitude) {
            $resolvedLocation = getLocationName($product->latitude, $product->longitude);
            if (!in_array($resolvedLocation, ['Coordinates Missing', 'Unknown Location', 'Error fetching location'], true)) {
                $location_name = $resolvedLocation;
            }
        }
        $relatedProducts = SellingPostRepository::getRelatedProducts($product);

        $user = UserRepository::query()->findOrFail($product->user_id);


        $reviewes = ReviewRepository::query()
            ->where('seller_id', $user->id)
            ->with('reviewer')
            ->get();

        $totalReviews = $reviewes->count();
        $averageRating = $totalReviews > 0 ? number_format($reviewes->avg('rating'), 1) : 0;

        // Dispatch view tracking to queue
        PostViewJob::dispatch($id, auth()->id(), request()->ip());

        $product->load('user'); // ensure user is loaded

        return \Inertia\Inertia::render('ProductDetails', [
            'product' => $product,
            'location_name' => $location_name,
            'relatedProducts' => $relatedProducts,
            'reviewes' => $reviewes,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
        ]);
    }


    //create
    public function productAd()
    {
        $colors = ColorRepository::getAll();
        $brands = BrandRepository::query()->active()->get();
        $categories = CategoryRepository::getAll();
        return \Inertia\Inertia::render('CreateAd', [
            'colors' => $colors,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function store(ProductRequest $request)
    {
        if (!auth()->check()) {
            $contact = $request->phone;
            $user = UserRepository::getUserByContact($contact);
            
            if (!$user && $request->email) {
                $user = UserRepository::getUserByContact($request->email);
            }

            if ($user) {
                // User exists, but not logged in. We must ask them to login for security.
                session(['url.intended' => url()->current()]);
                return redirect()->route('login')->with([
                    'error' => 'Nalog sa ovim podacima već postoji. Molimo prijavite se da biste objavili oglas.',
                    'contact' => $contact
                ]);
            }

            // Create a new user profile for NEW users
            if (!$request->user_name || !$request->email) {
                return redirect()->back()->withInput()->with('error', 'Molimo navedite svoje ime i email adresu za kreiranje naloga.');
            }

            $user = UserRepository::create([
                "name" => $request->user_name,
                "email" => $request->email,
                "phone_no" => $request->phone,
                "password" => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                'status' => \App\Enums\UserStatus::Approve->value,
            ]);
            $user->assignRole('User');

            \App\Events\NotifyManagementEvent::dispatch(
                null,
                $user->id,
                "Novi korisnik (Auto-registracija)",
                "Korisnik {$user->name} se registrovao putem objave oglasa."
            );
            
            auth()->login($user);
        }

        try {

            $post = SellingPostRepository::storeByRequest($request, auth()->id());

            $reviewersIds = ReviewRepository::query()
                ->where('seller_id', auth()->id())
                ->pluck('reviewer_id')
                ->toArray();

            $senderId = auth()->id();
            $subject = "A New Product Ad Post Created";

            // 1. Admin notification (receiver_id = null)
            NotifyManagementEvent::dispatch(
                [null],
                $senderId,
                $subject,
                "A new product post has been created by a seller. It is under review now."
            );

            // 2. Seller (auth user) notification
            NotifyManagementEvent::dispatch(
                [$senderId],
                $senderId,
                $subject,
                "You have successfully created a new product. Your post is now under admin review. We will notify you once it gets approved."
            );

            // 3. Reviewers notification
            if (!empty($reviewersIds)) {
                NotifyManagementEvent::dispatch(
                    $reviewersIds,
                    $senderId,
                    $subject,
                    "A user you reviewed has uploaded a new product. You can check it out."
                );
            }

            return redirect('/')
                ->with('success', 'Selling post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating selling post: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $product = SellingPostRepository::findOrFail($id);
        $colors = ColorRepository::getAll();
        $brands = BrandRepository::getAll()->where('is_active', 1);
        $categories = CategoryRepository::getAll();

        // Get assigned categories (parent & child)
        $categoryIds = $product->categories()->pluck('id')->toArray();
        $mainCategoryId = null;
        $subCategoryId = null;
        foreach ($categoryIds as $catId) {
            $cat = $categories->firstWhere('id', $catId);
            if ($cat) {
                if (!$cat->parent_id) {
                    $mainCategoryId = $cat->id;
                } else {
                    $subCategoryId = $cat->id;
                }
            }
        }

        // Load existing thumbnails
        $thumbnail = $product->thumbnails()->where('default', true)->first();
        $additionalImages = $product->thumbnails()->where('default', false)->get();

        return \Inertia\Inertia::render('EditAd', [
            'product' => $product,
            'colors' => $colors,
            'brands' => $brands,
            'categories' => $categories,
            'thumbnail' => $thumbnail,
            'additionalImages' => $additionalImages,
            'mainCategoryId' => $mainCategoryId,
            'subCategoryId' => $subCategoryId,
        ]);
    }

    public function update(Request $request, $id)
    {

        try {
            $post = SellingPostRepository::findOrFail($id);
            $post = SellingPostRepository::updateByRequest($post, $request);


            return redirect()->route('user.my-ads')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function makeCopy($id)
    {
        try {
            SellingPostRepository::makeCopypost($id);
            return redirect()->back()->with('success', 'Product copied successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error copying product: ' . $e->getMessage());
        }
    }


}
