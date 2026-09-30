<?php

namespace App\Http\Controllers\API;

use App\Enums\PostStatus;
use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiSearchProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\SellingPostRequest;
use App\Http\Requests\SoldOutRequest;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductResource;
use App\Jobs\PostViewJob;
use App\Models\Wishlist;
use App\Models\SellingPost;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ColorRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SearchKeyRepository;
use App\Repositories\SellingPostRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Products API')]
class ProductController extends Controller
{
    /**
     * Get Products
     *
     */

    #[QueryParameter('items_per_page', required: false, type: 'string', example: '9')]
    #[QueryParameter('page_number', required: false, type: 'string', example: '2')]
    #[QueryParameter('query', required: false, type: 'string', example: 'iPhone')]
    #[QueryParameter('conditions', required: false, type: 'array', example: ['Brand New', 'Used Like New'])]
    #[QueryParameter('location', required: false, type: 'string', example: 'Dhaka')]
    #[QueryParameter('brand', required: false, type: 'array', example: ['Apple', 'Samsung'])]
    #[QueryParameter('category', required: false, type: 'number', example: 3)]
    #[QueryParameter('min_price', required: false, type: 'number', example: 100)]
    #[QueryParameter('max_price', required: false, type: 'number', example: 1000)]
    #[QueryParameter('date', required: false, type: 'array', example: ['Today', 'Last 7 days'])]
    #[QueryParameter('price_sort', required: false, type: 'string', example: 'low_high', description: 'Options: low_high, high_low, recent')]


    public function index(Request $request, $category = null)
    {
        // Number of items per page
        $perPage = $request->input('items_per_page', 9);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        // Get filtered products query
        $query = SellingPostRepository::filterProducts($request, $category);
        // Apply skip & take for pagination
        $products = $query->skip($skip)
            ->take($perPage)
            ->latest()
            ->get();

        return $this->json($products->count() ? 'Products found' : 'No products found', [
            'total_items' => $products->count(), // items on this page
            'products' => ProductResource::collection($products),
        ], 200);
    }


    /**
     * Show Products
     *
     */

    #[QueryParameter('id', required: true, type: 'number', example: '11')]

    public function show($id)
    {
        try {
            $user = auth('sanctum')->user() ?? auth()->user();

            $product = SellingPostRepository::query()
                ->with(['user', 'brand', 'thumbnails', 'profile', 'categories'])
                ->findOrFail($id);

            PostViewJob::dispatch($id, $user?->id, request()->ip());

            return $this->json('Product fetched successfully', [
                'status' => true,
                'product' => ProductDetailsResource::make($product)
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->json('Product not found', ['status' => false], 404);
        } catch (\Exception $e) {
            return $this->json(
                'Something went wrong',
                [
                    'status' => false,
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }


    /**
     * Store Products
     *
     */

    #[BodyParameter('name', required: true, type: 'string', example: 'iPhone 14 Pro')]
    #[BodyParameter('condition', required: true, type: 'string', example: 'New')]
    #[BodyParameter('price', required: true, type: 'double', example: 1200)]
    #[BodyParameter('phone', required: true, type: 'string', example: '+8801XXXXXXXXX')]
    #[BodyParameter('email', required: false, type: 'string', example: 'user@example.com')]
    #[BodyParameter('description', required: true, type: 'string', example: 'Brand new phone with warranty')]
    #[BodyParameter('location', required: false, type: 'string', example: 'Dhaka, Bangladesh')]
    #[BodyParameter('latitude', required: false, type: 'number', example: 23.8103)]
    #[BodyParameter('longitude', required: false, type: 'number', example: 90.4125)]
    #[BodyParameter('brand_id', required: false, type: 'number', example: 1)]
    #[BodyParameter('warranty', required: false, type: 'number', example: 12)]
    #[BodyParameter('model', required: false, type: 'string', example: 'iPhone 14 Pro Max')]
    #[BodyParameter('color', required: false, type: 'string', example: 'Space Black')]
    #[BodyParameter('negotiable', required: false, type: 'boolean', example: true)]
    #[BodyParameter('category_id', required: true, type: 'number', example: 2)]
    #[BodyParameter('subcategory_id', required: false, type: 'number', example: 5)]
    #[BodyParameter('thumbnail', required: true, type: 'file', example: 'image.jpg')]
    #[BodyParameter('additional_images', required: false, type: 'array', example: ['image1.jpg', 'image2.jpg'])]

    public function store(SellingPostRequest $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->json('Login required', 401);
        }


        $post = SellingPostRepository::storeByRequest($request, auth()->id());
        $post->load('categories', 'thumbnails', 'profile',);

        // Notify reviewers
        $reviewersIds = ReviewRepository::query()
            ->where('seller_id', $user->id)
            ->pluck('reviewer_id')
            ->toArray();

        $receiverIds = array_merge([null, $user->id], $reviewersIds);

        NotifyManagementEvent::dispatch(
            $receiverIds,
            $user->id,
            "New Selling Post Created",
            "A new selling post ({$post->name}) has been created by {$user->name}"
        );

        return $this->json('Product created successfully', ['product' => $post], 200);
    }


    /**
     * Update Products
     *
     * @param ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    #[BodyParameter('name', required: true, type: 'string', example: 'iPhone 14 Pro')]
    #[BodyParameter('condition', required: true, type: 'string', example: 'New')]
    #[BodyParameter('price', required: true, type: 'double', example: 1200)]
    #[BodyParameter('phone', required: true, type: 'string', example: '+8801XXXXXXXXX')]
    #[BodyParameter('email', required: false, type: 'string', example: 'user@example.com')]
    #[BodyParameter('description', required: true, type: 'string', example: 'Brand new phone with warranty')]
    #[BodyParameter('location', required: false, type: 'string', example: 'Dhaka, Bangladesh')]
    #[BodyParameter('latitude', required: false, type: 'number', example: 23.8103)]
    #[BodyParameter('longitude', required: false, type: 'number', example: 90.4125)]
    #[BodyParameter('brand', required: false, type: 'number', example: 1)]
    #[BodyParameter('warranty', required: false, type: 'number', example: 12)]
    #[BodyParameter('model', required: false, type: 'string', example: 'iPhone 14 Pro Max')]
    #[BodyParameter('color', required: false, type: 'string', example: 'Space Black')]
    #[BodyParameter('negotiable', required: false, type: 'boolean', example: true)]
    #[BodyParameter('category_id', required: false, type: 'integer', example: 2)]
    #[BodyParameter('subcategory_id', required: false, type: 'number', example: 5)]
    #[BodyParameter('thumbnail', required: false, type: 'file', example: 'image.jpg')]
    #[BodyParameter('additional_images', required: false, type: 'array', example: ['image1.jpg', 'image2.jpg'])]
    #[BodyParameter('attributes', required: false, type: 'array', example: ['RAM' => '8GB', 'Storage' => '128GB'])]

    public function update(SellingPostRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        /** @var SellingPost $post */
        $post = SellingPostRepository::query()->findOrFail($id);
        if (!$post) {
            return $this->json('Product not found', [], 404);
        }

        $post = SellingPostRepository::updateByRequest($post, $request);
        $post->load('categories', 'thumbnails', 'profile',);

        return $this->json('Product updated successfully', [
            'product' => $post,
        ], 200);
    }

    /**
     * Copy Product
     *
     */

    #[QueryParameter('id', required: true, type: 'number', example: '11')]

    public function makeCopy($id)
    {
        try {
            $post = SellingPostRepository::makeCopypost($id);
            return $this->json('Product copied successfully', ['product' => $post]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error copying product: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Authenticate User Product Details
     */
    #[QueryParameter('id', required: true, type: 'number', example: '11')]

    public function postdetails($id)
    {

        $product = SellingPostRepository::getByIdWithRelations($id, ['wishlistedBy']);


        $product->loadCount('wishlistedBy');


        $location_name = getLocationName($product->latitude, $product->longitude);



        return $this->json('Product details fetched successfully', [
            'product' => $product,
            'wishlist_count' => $product->wishlisted_by_count,
            'location_name' => $location_name,
        ], 200);
    }


    /**
     * Authenticate User Ads
     */
    public function myAds(Request $request)
    {
        try {
            // Get wishlist IDs
            $wishlistIds = Wishlist::where('user_id', auth()->id())
                ->pluck('selling_post_id')
                ->toArray();

            // Query user posts
            $query = SellingPostRepository::query()
                ->where('user_id', auth()->id())
                ->with(['user', 'brand', 'thumbnails'])
                ->withCount('wishlistedBy');

            // Fetch according to ?all=1
            $products = $request->has('all')
                ? $query->get()
                : $query->take(6)->get();

            return $this->json('My ads fetched successfully', [
                'products' => ProductResource::collection($products),
                'wishlist_ids' => $wishlistIds,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching ads: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Move To Trash(My-Post)
     */
    #[QueryParameter('id', required: true, type: 'number', example: '11')]


    public function moveToTrash($id)
    {
        $post = SellingPostRepository::query()->find($id);

        if (!$post) {
            return $this->json('Post not found', null, 404);
        }

        $post->delete();

        return $this->json('Post deleted successfully', null, 200);
    }
    /**
     * Get Trash(My-Post)
     */

    public function trashed(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $posts = SellingPostRepository::query()->onlyTrashed()->paginate($perPage);

        return $this->json('Trashed posts retrieved successfully', [
            'posts' => $posts
        ], 200);
    }



    /**
     * Sold Out(My-Product)
     */
    #[QueryParameter('id', required: false, type: 'string', example: '1')]
    #[BodyParameter('product_id', required: true, type: 'string', example: '1')]
    #[BodyParameter('sold_price', required: true, type: 'string', example: '200')]
    #[BodyParameter('buyer_name', required: false, type: 'string', example: "ashik")]
    #[BodyParameter('updated_at', required: false, type: 'string', example: '')]


    public function soldout(SoldOutRequest $request)
    {
        $product = SellingPostRepository::findOrFail($request->product_id);

        $product->update([
            'status' => PostStatus::Soled->value,
            'sold_price' => $request->sold_price,
            'buyer_name' => $request->buyer_name,
            'is_sold' => true,
            'updated_at' => now(),
        ]);

        return $this->json('Product marked as sold successfully', null, 200);
    }

    /**
     * SoldOut All Products
     *
     */
    public function soldOutAds(Request $request)
    {
        $userId = Auth::guard('api')->user()->id;

        $soldOutAds = SellingPostRepository::query()
            ->where('user_id', $userId)
            ->where('status', 'Soled')
            ->latest()
            ->get();

        return $this->json('Sold out ads retrieved successfully', [
            'Products' => ProductResource::collection($soldOutAds)
        ], 200);
    }

    /**
     * Manage Search Key
     *
     */
    #[BodyParameter('search_key', required: true, type: 'string', example: 'iPhone 14 Pro')]
    public function searchManage(ApiSearchProductRequest $request)
    {
        SearchKeyRepository::storeOrUpdate($request);
        $suggestions = SearchKeyRepository::getSuggestions($request->search_key);
        $products =  SellingPostRepository::query()->where('name', 'LIKE', "%$request->search_key%")->get();

        return $this->json('Search key stored successfully.', [
            'search_key' => $request->search_key,
            'search_suggestions' => $suggestions,
            'products' => ProductResource::collection($products),
        ], 200);
    }

    /**
     * Restore Product
     *
     */
    #[QueryParameter('id', required: true, type: 'number', example: '11')]

    public function restore($id)
    {
        $post = SellingPostRepository::query()->onlyTrashed()->find($id);

        if (!$post) {
            return $this->json('Trashed Post not found', null, 404);
        }

        $post->restore();
        return $this->json('Post restored successfully', null, 200);
    }


    /**
     * Boosted Products
     *
     */
    public function boostedProducts(Request $request)
    {
        // Number of items per page
        $perPage = $request->input('items_per_page', 8);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        // Base query for boosted products
        $query = SellingPostRepository::query()->with([
            'user',
            'brand',
            'thumbnails',
            'boosts' => function ($q) {
                $q->where('expired_at', '>', now());
            }
        ])
            ->whereHas('boosts', function ($q) {
                $q->where('expired_at', '>', now());
            })
            ->where('is_sold', false)
            ->latest();

        // Pagination apply
        $products = $query->skip($skip)
            ->take($perPage)
            ->get();

        return $this->json('Boosted products found', [
            'page_number' => $pageNumber,
            'items_per_page' => $perPage,
            'total_items' => $products->count(), // Only this page items count
            'products' => ProductResource::collection($products),
        ], $products->count() ? 200 : 404);
    }

    /**
     * New Products
     */
    public function newProducts(Request $request)
    {
        // Number of items per page
        $perPage = $request->input('items_per_page', 8);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        // Base query for new products (latest posts)
        $query = SellingPostRepository::query()->with([
            'user',
            'brand',
            'thumbnails'
        ])
            ->where('is_sold', false)
            ->where('status', 'Approve')
            ->latest();

        // Pagination apply
        $products = $query->skip($skip)
            ->take($perPage)
            ->get();

        return $this->json(
            $products->count() ? 'New products found' : 'No new products found',
            [
                'page_number' => $pageNumber,
                'items_per_page' => $perPage,
                'total_items' => $products->count(), // Items only for this page
                'products' => ProductResource::collection($products),
            ],
            200
        );
    }
}
