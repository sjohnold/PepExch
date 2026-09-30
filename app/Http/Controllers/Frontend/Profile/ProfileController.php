<?php

namespace App\Http\Controllers\Frontend\Profile;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Setting;
use App\Models\Wishlist;
use App\Repositories\BoostPlanRepository;
use App\Repositories\BoostPostRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\NotificationHistoryRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    //Show Profile Page with data
    public function showProfile()
    {
        $myProfileData = UserRepository::query()->with('profilePhoto')->find(auth()->id());
        $languages = LanguageRepository::getAll()->where('status','1');

        return \Inertia\Inertia::render('Profile', [
            'profile' => $this->mapUser($myProfileData),
            'languages' => $languages->values(),
        ]);
    }


    public function changeLanguage($language)
    {
        $availableLanguages = LanguageRepository::getAll()->pluck('name')->toArray();

        if (in_array($language, $availableLanguages)) {
            session(['locale' => $language]);
            app()->setLocale($language);
        }

        return redirect()->back();
    }



    public function update(ProfileUpdateRequest $request, $id)
    {
        UserRepository::updateProfile($request, $id);
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function showMyAds(Request $request)
    {
        $wishlistIds = Wishlist::where('user_id', auth()->id())
            ->pluck('selling_post_id')
            ->toArray();

        $query = SellingPostRepository::query()
            ->where('user_id', auth()->id())
            ->with(['user', 'brand', 'thumbnails', 'profile', 'categories', 'activeBoost', 'offers'])
            ->withCount('views');


        if ($request->has('all')) {
            $products = $query->get();
        } else {
            $products = $query->take(6)->get();
        }

        return \Inertia\Inertia::render('MyAds', [
            'products' => $products->map(fn ($product) => $this->mapProduct($product))->values(),
            'wishlistIds' => $wishlistIds,
            'mode' => 'active',
        ]);
    }

    public function showWishlist()
    {
        // Fetch wishlist IDs
        $wishlistIds = Wishlist::where('user_id', auth()->id())->pluck('selling_post_id')->toArray();

        // Fetch products in wishlist
        $products = SellingPostRepository::query()
            ->whereIn('id', $wishlistIds)
            ->with(['user', 'brand', 'thumbnails', 'profile', 'categories', 'activeBoost', 'offers'])
            ->withCount('views')
            ->paginate(6);
        return \Inertia\Inertia::render('Wishlist', [
            'products' => $products->through(fn ($product) => $this->mapProduct($product)),
            'wishlistIds' => $wishlistIds,
        ]);
    }


    public function showUserNotifications()
    {
        $notifications = getNotifications(true);
        $notifications->getCollection()->load('notificationSender.profilePhoto');

        return \Inertia\Inertia::render('Notifications', [
            'notifications' => $notifications->through(fn ($notification) => $this->mapNotification($notification)),
        ]);
    }


    public function readSingleNotification(Request $request)
    {
        $notification = NotificationHistoryRepository::findOrFail($request->notification_id);
        $notification->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'redirect_url' => $notification->sender_id
                ? route('seller-info', $notification->sender_id)
                : route('user.show-notifications'),
        ]);
    }

    //Mak all notifications is_read ture
    public function readAllNotifications()
    {
        $id = auth()->id();
        NotificationHistoryRepository::query()->where('receiver_id', $id)->where('is_read', false)->update(['is_read' => true]);
        session()->flash('success', 'All notifications marked as read.');
        return redirect()->route('user.show-notifications');
    }

    public function reviewIndex()
    {
        $reviewes = ReviewRepository::query()->where('seller_id', auth()->id())->with('reviewer')->paginate(6);
        return view('web.profile.sections.review', compact('reviewes'));
    }

    public function moveToTrash($id)
    {

        $post = SellingPostRepository::query()->where('user_id', auth()->id())->findOrFail($id);

        // Soft delete
        $post->delete();

        return back()->with('success', 'Post moved to trash!');
    }


    public function trashIndex()
    {
        $products = SellingPostRepository::trashedByUser(auth()->id())->get();
        return view('web.profile.sections.trash', compact('products'));
    }
    public function restore($id)
    {
        SellingPostRepository::restoreByUser($id, auth()->id());
        return back()->with('success', 'Post restored successfully!');
    }


    public function showPromoteAds($id)
    {
        $product = SellingPostRepository::query()->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $boostPlans = BoostPlanRepository::getAll();

        return view('web.profile.sections.promot-ads', compact('product', 'boostPlans'));
    }


    public function soldout($id)
    {
        $product = SellingPostRepository::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }
        $product->status = 'Soled';
        $product->save();

        return redirect()->back()->with('success', 'Product marked as Sold Out!');
    }

    public function soldOutAds(Request $request)
    {

        $userId = auth()->id();

        $soldOutAds = SellingPostRepository::query()
            ->where('user_id', $userId)
            ->where('status', 'Soled')
            ->withCount('views')
            ->latest()
            ->get();

        $soldOutAds->load(['user', 'brand', 'thumbnails', 'profile', 'categories', 'activeBoost', 'offers']);

        return \Inertia\Inertia::render('MyAds', [
            'products' => $soldOutAds->map(fn ($product) => $this->mapProduct($product))->values(),
            'wishlistIds' => [],
            'mode' => 'sold',
        ]);
    }

    public function markAsSold(Request $request)
    {

        $product = SellingPostRepository::findOrFail($request->product_id);
        $product->update([
            'status' => PostStatus::Soled->value,
            'sold_price' => $request->sold_price,
            'buyer_name' => $request->buyer_name,
            'is_sold' => true,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Product marked as sold successfully!');
    }

    private function mapUser($user): array
    {
        return [
            'id' => $user?->id,
            'name' => $user?->name,
            'email' => $user?->email,
            'phone_no' => $user?->phone_no,
            'whatsapp_number' => $user?->whatsapp_number,
            'address' => $user?->address,
            'latitude' => $user?->latitude,
            'longitude' => $user?->longitude,
            'profile_photo_path' => $user?->profilePhotoPath ?? asset('media/demo-img.png'),
            'email_verified' => (bool) $user?->email_verified_at,
            'phone_verified' => (bool) $user?->phone_verified_at,
        ];
    }

    private function mapProduct($product): array
    {
        $category = $product->categories?->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'title' => $product->name,
            'description' => $product->description,
            'desc' => $product->description,
            'status' => $product->status,
            'created_label' => $product->created_at?->diffForHumans() ?? __('Just now'),
            'profilePath' => $product->profilePath,
            'img_url' => $product->profilePath,
            'thumbnail' => $product->profilePath,
            'location' => $product->location,
            'location_name' => $product->location_name,
            'category' => [
                'id' => $category?->id,
                'name' => $category?->name,
            ],
            'categories' => $product->categories?->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ])->values() ?? [],
            'views_count' => $product->views_count ?? $product->number_of_view ?? 0,
            'offers_count' => $product->relationLoaded('offers') ? $product->offers->count() : 0,
            'is_boosted' => (bool) $product->activeBoost,
        ];
    }

    private function mapNotification($notification): array
    {
        return [
            'id' => $notification->id,
            'subject' => $notification->subject,
            'body' => $notification->body,
            'is_read' => (bool) $notification->is_read,
            'created_label' => $notification->created_at?->diffForHumans() ?? '',
            'sender_id' => $notification->sender_id,
            'sender_name' => $notification->notificationSender?->name ?? __('PepExch'),
            'sender_photo' => $notification->notificationSender?->profilePhotoPath ?? asset('media/demo-img.png'),
            'redirect_url' => $notification->sender_id
                ? route('seller-info', $notification->sender_id)
                : route('user.show-notifications'),
        ];
    }
}
