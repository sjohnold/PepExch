<?php
namespace App\Http\Controllers\Frontend;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerReviewRequest;
use App\Repositories\ReviewRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class SellerinfoController extends Controller
{

    public function index(Request $request, $id)
    {
        $lowToHigh  = $request->query('low_to_high');
        $highToLow  = $request->query('high_to_low');
        $recentItem = $request->query('recent-item');
        $all        = $request->query('all');

        $user     = UserRepository::query()->findOrFail($id);
        $reviewes = ReviewRepository::query()
            ->where('seller_id', $user->id)
            ->with('reviewer')
            ->paginate(10)
            ->appends(request()->query());

        $totalReviews = count($reviewes);

        $averageRating = $totalReviews > 0 ? number_format($reviewes->avg('rating'), 1) : 0;

        $productsQuery = $user->sellingPosts()
            ->where('status', PostStatus::Approve->value)
            ->where('is_sold', false);

        if ($lowToHigh) {
            $productsQuery->orderBy('asking_price', 'asc');
        } elseif ($highToLow) {
            $productsQuery->orderBy('asking_price', 'desc');
        } elseif ($recentItem) {
            $productsQuery->orderBy('created_at', 'desc');
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        $products = $productsQuery->paginate(10);

        // Realted Prosucts
        $productId = $request->query('product_id');
        if ($productId) {
            $post = SellingPostRepository::query()->find($productId);
            $categoryId = $post ? $post->categories()->first()?->id : null;

            $relatedPosts = SellingPostRepository::query()
                ->where('status', 'Approve')
                ->where('is_sold', false)
                ->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->inRandomOrder()
                ->limit(5)
                ->get();
        } else {
            $relatedPosts = collect();
        }

        $product = $productId ? SellingPostRepository::query()->find($productId) : null;
        return view('web.sellerinfo.sellerinfo', compact('user', 'products', 'relatedPosts', 'reviewes', 'totalReviews', 'averageRating', 'product'));
    }

    public function storeReview(SellerReviewRequest $request)
    {
        if (auth()->check() && $request->seller_id && $request->reviewer_id) {
            ReviewRepository::storeReviewReq($request);
            return back()->withSuccess('Review Added Successfully');
        }
        return back()->withError('Please login to submit a review.');
    }
}
