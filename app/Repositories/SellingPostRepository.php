<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enums\PostStatus;
use App\Events\NotifyManagementEvent;
use App\Models\SellingPost;
use App\Models\User;
use App\Services\ListingRecommendation;
use App\Services\MarketplaceSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class  SellingPostRepository extends Repository
{
    public static function model()
    {
        return SellingPost::class;
    }


    public static function getByStatus($status = null, $perPage = 0, $search = null)
    {
        $query = self::query()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('contact_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($q2) use ($search) {
                            $q2->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('brand', function ($q2) use ($search) {
                            $q2->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc'); // Added descending order

        // Paginate only at the end
        return $perPage ? $query->withTrashed()->paginate($perPage)->withQueryString() : $query->withTrashed()->get();
    }

    public static function countByStatus($status = null)
    {
        return $status ? self::model()::where('status', $status)->count() : self::model()::count();
    }

    public static function getTrashed($perPage = 10)
    {
        return SellingPost::onlyTrashed()->paginate($perPage);
    }


    public static function updatePostWithMedia(SellingPost $post, array $data): SellingPost
    {
        $oldStatus = $post->status;
        // Basic info
        $post->name = $data['name'] ?? $post->name;
        $post->conditions = $data['condition'] ?? $post->conditions;
        $post->contact_number = $data['phone'] ?? $post->contact_number;
        $post->email = $data['email'] ?? $post->email;
        $post->description = $data['description'] ?? $post->description;
        $post->latitude = $data['latitude'] ?? $post->latitude;
        $post->longitude = $data['longitude'] ?? $post->longitude;
        $post->warranty_left = $data['warranty'] ?? $post->warranty_left;
        $post->model = $data['model'] ?? $post->model;
        $post->color_code = $data['color'] ?? $post->color_code;
        $post->is_negotiable = !empty($data['negotiable']);
        $post->status = $data['status'] ?? $post->status;
        $post->is_sold = !empty($data['is_sold']);
        $post->brand_id = $data['brand'] ?? $post->brand_id;

        $post->save();


        if (!empty($data['thumbnail'])) {
            $media = MediaRepository::storeByRequest($data['thumbnail'], 'thumbnails');
            $post->media_id = $media->id;
            $post->save();

            if (!$post->thumbnails->contains($media->id)) {
                $post->thumbnails()->attach($media->id, ['default' => true]);
            }
        }


        // Remove selected images
        foreach ($data['remove_additional_images'] ?? [] as $src) {
            $media = $post->thumbnails()->where('src', $src)->first();
            if ($media) {
                $post->thumbnails()->detach($media->id);
                // optionally delete from storage: Storage::delete($media->src);
            }
        }


        $existingImages = $data['existing_additional_images'] ?? [];
        $currentImages = $post->thumbnails->pluck('src')->toArray();


        foreach ($currentImages as $src) {
            if (!in_array($src, $existingImages) && empty($data['remove_additional_images'])) {
                $media = $post->thumbnails()->where('src', $src)->first();
                if ($media) {
                    $post->thumbnails()->detach($media->id);
                }
            }
        }


        foreach ($data['additional_images'] ?? [] as $file) {
            $media = MediaRepository::storeByRequest($file, 'additional_images');
            $post->thumbnails()->attach($media->id, ['default' => false]);
        }


        $categories = array_filter([$data['category'] ?? null, $data['subcategory'] ?? null]);
        $post->categories()->sync($categories);


        if (!empty($data['attributes']) && is_array($data['attributes'])) {
            $post->attributes()->sync($data['attributes']);
        } else {
            $post->attributes()->detach();
        }


        if ($oldStatus !== $post->status) {

            $receiverIds = [$post->user_id];
            $senderId = auth()->id();
            $subject = "";
            $body = "";

            if ($post->status === PostStatus::Approve->value) {
                $subject = "Post Approved";
                $body = "Your post '{$post->name}' has been approved and is now live.";
            }

            if ($post->status === PostStatus::Reject->value) {
                $subject = "Post Rejected";
                $body = "Unfortunately, your post '{$post->name}' has been rejected by our team.";
            }

            if ($post->status === PostStatus::Cancel->value) {
                $subject = "Post Cancelled";
                $body = "Your post '{$post->name}' has been cancelled.";
            }

            if ($post->status === PostStatus::InReview->value) {
                $subject = "Post Under Review";
                $body = "Your post '{$post->name}' is currently being reviewed by our management.";
            }

            // Dispatch only if a subject was set
            if (!empty($subject)) {
                NotifyManagementEvent::dispatch(
                    $receiverIds,
                    $senderId,
                    $subject,
                    $body
                );
            }
        }

        return $post;
    }

    // ================= NEW METHODS =================

    public static function getByIdWithRelations($id, array $relations = ['user', 'brand', 'thumbnails'])
    {
        return self::query()->with($relations)->findOrFail($id);
    }

    private static function locationFromRequest(Request $request, ?string $fallback = null): ?string
    {
        $location = trim((string) $request->input('location', ''));

        if ($location !== '') {
            return $location;
        }

        $city = trim((string) $request->input('city', ''));
        $country = trim((string) $request->input('country', ''));

        if ($city === '') {
            return $fallback;
        }

        $parts = array_filter([$city, $country], fn($part) => $part !== '');

        return !empty($parts) ? implode(', ', $parts) : $fallback;
    }

    public static function getRelatedProducts($product)
    {
        return app(ListingRecommendation::class)->forListing($product);
    }

    public static function getDistinctConditions()
    {
        return self::query()->select('conditions')->distinct()->pluck('conditions');
    }

    public static function getLocationsWithCount()
    {
        $addresses = SellingPostRepository::query()->pluck('location'); // pura address

        $counts = [];

        foreach ($addresses as $address) {
            $location = trim($address); // pura string
            if ($location !== '') {
                // duplicate remove + count
                $counts[$location] = isset($counts[$location]) ? $counts[$location] + 1 : 1;
            }
        }

        // alphabetical sort optional
        ksort($counts);

        return collect($counts);
    }

    public static function getBrandsWithCount()
    {
        return self::query()
            ->with('brand')
            ->get()
            ->groupBy(fn($post) => $post->brand->name ?? 'Unknown')
            ->map(fn($posts, $brand) => $posts->count());
    }
    public static function getDateFiltersWithCount()
    {
        $now = now();

        $ranges = [
            'All Time' => null,
            'Today' => $now->copy()->startOfDay(),
            'Within 1 Week' => $now->copy()->subWeek(),
            'Within 2 Weeks' => $now->copy()->subWeeks(2),
            'Within 1 Month' => $now->copy()->subMonth(),
        ];

        $result = [];

        foreach ($ranges as $label => $date) {
            if ($date) {
                $result[$label] = self::query()
                    ->where('created_at', '>=', $date)
                    ->count();
            } else {
                $result[$label] = self::query()->count();
            }
        }

        return $result;
    }

    public static function getDealMethods()
    {
        return self::query()
            ->select('deal_method')
            ->distinct()
            ->pluck('deal_method')
            ->filter();
    }
    public static function getBoostedProducts($limit = 10)
    {
        $query = self::query()
            ->with(['user', 'brand', 'thumbnails', 'boosts' => function ($q) {
                $q->where('expired_at', '>', now());
            }])
            ->whereHas('boosts', function ($q) {
                $q->where('expired_at', '>', now());
            })
            ->where('is_sold', false)
            ->latest();

        return $limit ? $query->take($limit)->get() : $query->get();
    }


    public static function getNewProducts($limit = 8)
    {
        return self::query()
            ->with(['user', 'brand', 'defaultThumbnail']) // default only
            ->where('status', 'Approve')
            ->latest()
            ->take($limit)
            ->get();
    }

    public static function trashedByUser($userId)
    {
        return self::query()->onlyTrashed()->where('user_id', $userId);
    }

    public static function restoreByUser($postId, $userId)
    {
        $post = self::query()->onlyTrashed()
            ->where('user_id', $userId)
            ->findOrFail($postId);

        $post->restore();

        return $post;
    }

    public static function storeByRequest(Request $request, int $userId): SellingPost
    {
        // 1️ Create main post
        $post = SellingPost::create([
            'name'           => $request->name,
            'conditions'     => $request->condition,
            'asking_price'   => $request->price ?? 0,
            'contact_number' => $request->phone,
            'email'          => $request->email,
            'description'    => $request->description,
            'latitude'       => $request->latitude ?? null,
            'longitude'      => $request->longitude ?? null,
            'location'       => self::locationFromRequest($request),
            'brand_id'       => $request->brand ?? null,
            'warranty_left'  => $request->warranty ?? null,
            'model'          => $request->model ?? null,
            'color_code'     => $request->color ?? null,
           'is_negotiable' => (bool) $request->negotiable,
            'status'         => 'Pending',
            'user_id'        => $userId,
        ]);

        // 2️Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $post->update(['media_id' => $media->id]);
        }

        // 3️ Handle additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $media = MediaRepository::storeByRequest($file, 'additional_images');
                $post->thumbnails()->attach($media->id, ['default' => false]);
            }
        }

        // 4️ Handle categories
        $categories = array_filter([$request->category, $request->subcategory]);
        if (!empty($categories)) {
            $post->categories()->sync($categories);
        }

        // 5️Handle attributes
        if ($request->filled('attributes') && is_array($request->input('attributes'))) {
            $post->attributes()->sync($request->input('attributes'));
        }

        return $post;
    }


    public static function updateByRequest(SellingPost $post, Request $request): SellingPost
    {

        $post->name = $request->name;
        $post->conditions = $request->condition;
        $post->contact_number = $request->phone ?? null;
        $post->email = $request->email ?? null;
        $post->description = $request->description;
        $post->location = self::locationFromRequest($request, $post->location);
        $post->latitude = $request->latitude ?? $post->latitude;
        $post->longitude = $request->longitude ?? $post->longitude;
        $post->brand_id = $request->brand ?? null;
        $post->warranty_left = $request->warranty ?? null;
        $post->model = $request->model ?? null;
        $post->color_code = $request->color ?? null;
        $post->status = 'Pending';
        $post->save();


        if ($request->hasFile('thumbnail')) {
            $oldMedia = $post->profile ?? null;

            if ($oldMedia && Storage::disk('public')->exists($oldMedia->src)) {
                Storage::disk('public')->delete($oldMedia->src);
            }

            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $post->media_id = $media->id;
            $post->save();
        }


        $existingImages = $request->existing_additional_images ?? [];
        $existingMediaIds = [];

        foreach ($existingImages as $src) {
            $media = $post->thumbnails()->where('src', $src)->first();
            if ($media) $existingMediaIds[] = $media->id;
        }


        if (!empty($request->remove_additional_images) && is_array($request->remove_additional_images)) {
            foreach ($request->remove_additional_images as $src) {
                $media = $post->thumbnails()->where('src', $src)->first();
                if ($media) {
                    $post->thumbnails()->detach($media->id);
                    if (Storage::disk('public')->exists($media->src)) {
                        Storage::disk('public')->delete($media->src);
                    }
                }
            }
        }


        $post->thumbnails()->syncWithoutDetaching($existingMediaIds);


        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $media = MediaRepository::storeByRequest($file, 'additional_images');
                $post->thumbnails()->attach($media->id, ['default' => false]);
            }
        }


        $categories = array_filter([$request->category, $request->subcategory]);
        $post->categories()->sync($categories);


        if ($request->filled('attributes') && is_array($request->input('attributes'))) {
            $post->attributes()->sync($request->input('attributes'));
        }

        return $post;
    }

    public static function makeCopypost(int $id): SellingPost
    {
        // Find the original product
        $original = self::findOrFail($id);

        // Clone the main attributes
        $copy = $original->replicate();
        $copy->name = $original->name . ' (Copy)';
        $copy->status = 'Pending';
        $copy->is_sold = 0;
        $copy->sold_price = null;
        $copy->created_at = now();
        $copy->updated_at = now();
        $copy->save();

        // Clone categories
        $categoryIds = $original->categories()->pluck('id')->toArray();
        if (!empty($categoryIds)) {
            $copy->categories()->attach($categoryIds);
        }

        // Clone attributes
        $attributeIds = $original->attributes()->pluck('id')->toArray();
        if (!empty($attributeIds)) {
            $copy->attributes()->attach($attributeIds);
        }

        // Clone main thumbnail
        if ($original->media_id) {
            $originalMedia = $original->profile; // Assuming 'profile' relationship returns Media model

            if ($originalMedia && Storage::disk('public')->exists($originalMedia->src)) {
                // Duplicate the file
                $filePath = $originalMedia->src;
                $newFileName = 'thumbnails/' . uniqid() . '-' . basename($filePath);
                Storage::disk('public')->copy($filePath, $newFileName);

                // Create a new Media record
                $newMedia = $originalMedia->replicate();
                $newMedia->src = $newFileName;
                $newMedia->save();

                $copy->media_id = $newMedia->id;
                $copy->save();
            }
        }

        // Clone additional images
        $originalMediaIds = $original->thumbnails->pluck('id')->toArray();
        if (!empty($originalMediaIds)) {
            $copy->thumbnails()->attach($originalMediaIds);
        }

        return $copy;
    }

    public static function getSellingPostReport()
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $type = request()->type ?? 'monthly';

        $labels = [];
        $postCounts = [];
        $offerCounts = [];

        if ($type == 'monthly') {
            $daysInMonth = Carbon::create($year, $month)->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = str_pad($d, 2, '0', STR_PAD_LEFT);
                $date = Carbon::create($year, $month, $d)->toDateString();
                $postCounts[] = \App\Models\SellingPost::whereDate('created_at', $date)->count();
                $offerCounts[] = \App\Models\Offer::whereDate('created_at', $date)->count();
            }
        } elseif ($type == 'yearly') {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            foreach ($months as $index => $mName) {
                $labels[] = $mName;
                $mNum = $index + 1;
                $postCounts[] = \App\Models\SellingPost::whereYear('created_at', $year)->whereMonth('created_at', $mNum)->count();
                $offerCounts[] = \App\Models\Offer::whereYear('created_at', $year)->whereMonth('created_at', $mNum)->count();
            }
        } else {
            $labels = ['Today'];
            $postCounts = [\App\Models\SellingPost::whereDate('created_at', now())->count()];
            $offerCounts = [\App\Models\Offer::whereDate('created_at', now())->count()];
        }

        return [
            'labels' => $labels,
            'post_count' => $postCounts,
            'offer_count' => $offerCounts,
        ];
    }

    public static function getNearProducts($request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        if (!$latitude || !$longitude) {
            return collect();
        }

        $products = self::query()
            ->where('status', 'Approve')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->selectRaw(
                '*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) )
                * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->orderBy('distance', 'ASC')

            ->take(10)
            ->get();

        return $products;
    }

    public static function filterProducts($request, $routeCategoryId = null)
    {
        $query = self::query()->with(['user', 'brand', 'thumbnails', 'categories'])
            ->where('status', 'Approve')
            ->where('is_sold', false);

        //  Search filter
        if ($request->filled('product_search') || $request->filled('search')) {
            $search = $request->query('product_search', $request->query('search'));
            app(MarketplaceSearch::class)->apply($query, $search);
        }

        // Condition filter
        if ($request->filled('conditions') || $request->filled('condition')) {
            $conditions = $request->input('conditions', $request->input('condition'));
            if (!is_array($conditions)) {
                $conditions = explode(',', $conditions);
            }
            $query->whereIn('conditions', $conditions);
        }


        if ($request->filled('location')) {
            $locations = is_array($request->location) ? $request->location : [$request->location];

            $query->whereIn('location', $locations);
        }



        // 🏷 Brand filter
        if ($request->filled('brand')) {
            $brands = (array) $request->input('brand');
            $query->whereHas('brand', function ($q) use ($brands) {
                $q->whereIn('name', $brands);
            });
        }

        //  Date filter (array or single)
        if ($request->has('date') && is_array($request->date)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->date as $dateFilter) {
                    switch ($dateFilter) {
                        case 'Last 24 hours':
                            $q->orWhere('created_at', '>=', now()->subHours(24));
                            break;
                        case 'Last 7 days':
                            $q->orWhere('created_at', '>=', now()->subDays(7));
                            break;
                        case 'Last 30 days':
                            $q->orWhere('created_at', '>=', now()->subDays(30));
                            break;
                        case 'Today':
                            $q->orWhereDate('created_at', today());
                            break;
                    }
                }
            });
        }

        if ($request->filled('date') && !is_array($request->date)) {
            switch ($request->date) {
                case 'Last 24 hours':
                    $query->where('created_at', '>=', now()->subHours(24));
                    break;
                case 'Last 7 days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case 'Last 30 days':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'Today':
                    $query->whereDate('created_at', today());
                    break;
            }
        }

        //  Category filter
        $categoryId = $routeCategoryId ?: $request->input('category');

        if (!empty($categoryId)) {
            $categoryIds = CategoryRepository::query()
                ->where('parent_id', $categoryId)
                ->pluck('id')
                ->push($categoryId);

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('id', $categoryIds);
            });
        }

        //  Price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween(
                'asking_price',
                [(float) $request->min_price, (float) $request->max_price]
            );
        }

        // ↕ Price sort
        if ($request->price_sort == 'low_high') {
            $query->reorder('asking_price', 'asc');
        } elseif ($request->price_sort == 'high_low') {
            $query->reorder('asking_price', 'desc');
        } elseif ($request->price_sort == 'recent') {
            $query->reorder('created_at', 'desc');
        } elseif (!$request->filled('product_search') && !$request->filled('search')) {
            $query->latest();
        }

        return $query;
    }




    // Pruducts Reports

    public static function getProductsByDateRange($range, $request)
    {
        return self::query()
            ->when($range == 'today', fn($q) => $q->whereDate('created_at', Carbon::today()))
            ->when($range == 'yesterday', fn($q) => $q->whereDate('created_at', Carbon::yesterday()))
            ->when($range == 'last_7_days', fn($q) => $q->whereBetween('created_at',[Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()]))                                                                                 // Last 7 days
            ->when($range == 'last_30_days', fn($q) => $q->whereBetween('created_at',[Carbon::now()->subDays(29)->startOfDay(), Carbon::now()->endOfDay()]))                                                                                 // Last 30 days
            ->when($range == 'custom' && $request->filled(['start_date','end_date']), fn($q) => $q->whereBetween(
                'created_at',
                [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]
            ))->orderByDesc('created_at')->get();
    }


    public static function getDateRangeTitle($range, $request)
    {
        return match($range) {
            'today' => 'Today - ' . Carbon::today()->format('d M Y'),
            'yesterday' => 'Yesterday - ' . Carbon::yesterday()->format('d M Y'),
            'last_7_days' => 'Last 7 Days (' . Carbon::now()->subDays(6)->format('d M Y') . ' - ' . Carbon::now()->format('d M Y') . ')',
            'last_30_days' => 'Last 30 Days (' . Carbon::now()->subDays(29)->format('d M Y') . ' - ' . Carbon::now()->format('d M Y') . ')',
            'custom' => $request->filled(['start_date', 'end_date'])
                ? Carbon::parse($request->start_date)->format('d M Y') . ' - ' . Carbon::parse($request->end_date)->format('d M Y')
                : 'Custom Range',
            default => 'All Time',
        };
    }


    public static function getReportStats($products)
    {
        return [
            'total' => $products->count(),
            'approved' => $products->where('status', PostStatus::Approve->value)->count(),
            'pending' => $products->where('status', PostStatus::Pending->value)->count(),
            'blocked' => $products->where('status', PostStatus::InReview->value)->count(),
            'Reject' => $products->where('status', PostStatus::Reject->value)->count(),
            'Soled' => $products->where('status', PostStatus::Soled->value)->count(),
            'Cancel' => $products->where('status', PostStatus::Cancel->value)->count(),
        ];
    }

}
