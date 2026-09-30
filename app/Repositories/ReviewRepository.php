<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Events\NotifyManagementEvent;
use App\Models\Offer;
use App\Models\Review;

class ReviewRepository extends Repository
{
    public static function model()
    {
        return Review::class;
    }

    public static function storeReviewReq($request)
    {
        $existReview = self::query()
            ->where('seller_id', $request->seller_id)
            ->where('reviewer_id', $request->reviewer_id)
            ->first();

        if (!$existReview) {
            self::create([
                'seller_id' => $request->seller_id,
                'reviewer_id' => $request->reviewer_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // Notfactions
            $reviewer = UserRepository::query()->find($request->reviewer_id);
            $receiverIds = $request->seller_id;
            $senderId = auth()->id();
            $subject = "Congratulations..!! You got new review";
            $body = "You have received a new review from {$reviewer->name}";
            // Notification
            NotifyManagementEvent::dispatch(
                $receiverIds,
                $senderId,
                $subject,
                $body
            );

            return redirect()->back()->with('success', 'Review created successfully.');
        } else {
            return redirect()->back()->with('error', 'You have already reviewed this person.');
        }
    }


    public static function getTopSellers($limit = 5)
    {
        $topSellers = self::query()->select('seller_id')
            ->selectRaw('COUNT(*) as review_count')
            ->selectRaw('AVG(rating) as avg_rating')
            ->groupBy('seller_id')
            ->orderBy('avg_rating', 'desc')
            ->orderBy('review_count', 'desc')
            ->take($limit)
            ->get();

        $result = [];

        foreach ($topSellers as $seller) {
            $user = UserRepository::query()->find($seller->seller_id);
            $postCount = SellingPostRepository::query()->where('user_id', $seller->seller_id)
                ->where('status', 'Approve')
                ->count();

            $result[] = [
                'seller' => $user,
                'email' => $user?->email,
                'review_count' => $seller->review_count,
                'avg_rating' => round($seller->avg_rating, 1),
                'post_count' => $postCount,
                'completed_exchanges' => Offer::query()
                    ->where('status', 'completed')
                    ->where(function ($query) use ($seller) {
                        $query->where('sender_id', $seller->seller_id)
                            ->orWhere('receiver_id', $seller->seller_id);
                    })
                    ->count(),
                'profile_photo' => $user ? $user->profilePhotoPath : 'https://placehold.jp/250x250.png', // নতুন লাইন
            ];
        }

        return $result;
    }
}
