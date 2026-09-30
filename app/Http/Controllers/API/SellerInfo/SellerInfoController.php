<?php

namespace App\Http\Controllers\API\SellerInfo;

use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerReportRequest;
use App\Http\Requests\SellerReviewRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SellerInfo\SellerProductResource;
use App\Http\Resources\SellerInfo\SellerReviewResource;
use App\Http\Resources\SellerInfo\SellerUserResource;
use App\Models\Review;
use App\Repositories\ReportSellerRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\UserRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Seller Info')]
class SellerInfoController extends Controller
{
    /**
     * Seller Infomation
     *
     */

    #[BodyParameter('user_id', required: true, type: 'integer', example: 1)]
    #[BodyParameter('low_to_high', required: true, type: 'bool', example: true)]
    #[BodyParameter('high_to_low', required: true, type: 'bool', example: false)]
    #[BodyParameter('items_per_page', required: true, type: 'integer', example: 10)]
    #[BodyParameter('page_number', required: true, type: 'integer', example: 1)]

    public function index(Request $request)
    {
        $id = $request->input('user_id');
        $lowToHigh = $request->input('low_to_high');
        $highToLow = $request->input('high_to_low');


        $perPage = $request->input('items_per_page', 10);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;


        $user = UserRepository::query()->findOrFail($id);

        $productsQuery = SellingPostRepository::query()->where('user_id', $id);

        if ($lowToHigh) {
            $productsQuery->orderBy('asking_price', 'asc');
        } elseif ($highToLow) {
            $productsQuery->orderBy('asking_price', 'desc');
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }
        $total_product = $productsQuery->count();
        $products = $productsQuery->skip($skip)->take($perPage)->get();

        $query = ReviewRepository::query()->where('seller_id', $user->id);
        $reviewCount = $query->count();

        $totalRating = $query->sum('rating');
        $averageRating = $reviewCount > 0 ? number_format($totalRating / $reviewCount, 1) : 0;

        $data = [
            'total_product' => $total_product,
            'total_product_per_request' => count($products),
            'reviewCount' => (int) $reviewCount,
            'averageRating' => (float) $averageRating,
            'user' => SellerUserResource::make($user),
            'products' => ProductResource::collection($products),
        ];
        return $this->json('seller info fetched', $data);
    }


    /**
     * Show Review
     *
     * ## Endpoint URL:
     * ```
     * GET {{live_url}}/seller/review/show/{id}
     * ```
     *
     * ## Path Parameter:
     * - **id** (integer, required): Seller/User ID whose reviews will be fetched
     *
     * ## Example URL:
     * ```
     * {{live_url}}/seller/review/show/34?items_per_page=10&page_number=1
     * ```
     *
     * ## Explanation:
     * - `34` → Seller/User ID
     * - `items_per_page=10` → Number of reviews per page
     * - `page_number=1` → Page number for pagination
     */
    #[BodyParameter('id', required: true, type: 'integer', example: 1)]
    #[BodyParameter('items_per_page', required: true, type: 'integer', example: 10)]
    #[BodyParameter('page_number', required: true, type: 'integer', example: 1)]
    public function showReview(Request $request,  $id)
    {

        $perPage = $request->input('items_per_page', 10);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        $reviewQuery = ReviewRepository::query()->where('seller_id', $id)->with('reviewer');
        $totalReviews = $reviewQuery->count();
        $reviewes = $reviewQuery->skip($skip)->take($perPage)->get();
        $reviewsPerPage = $reviewes->count();

        $data = [
            'totalReviews' => $totalReviews,
            'reviewsPerPage' => $reviewsPerPage,
            'reviewes' => SellerReviewResource::collection($reviewes),
        ];

        return $this->json('show all reviews fetched successfully', $data, 200);
    }


    /**
     * Store Review
     *
     */

    #[BodyParameter('seller_id', required: true, type: 'integer', example: 1)]
    #[BodyParameter('rating', required: true, type: 'integer', example: 5)]
    #[BodyParameter('comment', required: true, type: 'text', example: "Good Product")]

    public function storeReview(SellerReviewRequest $request, $id)
    {
        if (!auth()->check()) {
            return $this->json('Unauthorized', [], 401);
        }

        $reviewerId = auth()->id();
        $sellerId = $id;

        // Check existing review
        $existReview = ReviewRepository::query()->where('seller_id', $sellerId)->where('reviewer_id', $reviewerId)->first();

        if ($existReview) {
            return $this->json('You have already reviewed this seller.', null, 200);
        }

        // Create review
        $newReview = ReviewRepository::create([
            'seller_id' => $sellerId,
            'reviewer_id' => $reviewerId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Notification
        $reviewer = auth()->user();
        $receiverIds = $sellerId;
        $senderId = $reviewer->id;
        $subject = "Congratulations..!! You got new review";
        $body = "You have received a new review from {$reviewer->name}";

        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );

        return $this->json(
            'Review submitted successfully.',
            null,
            200
        );
    }

    /**
     * Store Report
     *
     */

    #[BodyParameter('seller_id', required: true, type: 'integer', example: 1)]
    #[BodyParameter('report_type', required: true, type: 'string', example: "scam")]
    #[BodyParameter('details', required: true, type: 'text', example: "Your product is bad")]

    public function storeReport(SellerReportRequest $request, $id)
    {
        $report = ReportSellerRepository::create([
            'seller_id' => $id,
            'reporter_id' => auth()->user()->id,
            'report_type' => $request->report_type,
            'details' => $request->details,
        ]);

        //Mail
        if ($report) {
            $receiverIds = null;
            $senderId = auth()->id();
            $subject = "New Report";
            $body = "A user {$report->reporter->name} reported seller {$report->seller->name}";


            // Start Notification
            NotifyManagementEvent::dispatch(
                $receiverIds,
                $senderId,
                $subject,
                $body
            );
        }

        return $this->json('Reported Sucessfully', [], 200);
    }
}
