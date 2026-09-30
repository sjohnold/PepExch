<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistRepository extends Repository
{
    public static function model()
    {
        return Wishlist::class;
    }


    public static function toggleWishlist($postId)
    {
        $userId = Auth::id();

        $exists = self::query()->where('user_id', $userId)
            ->where('selling_post_id', $postId)
            ->exists();

        if ($exists) {
            self::query()->where('user_id', $userId)
                ->where('selling_post_id', $postId)
                ->delete();
            return 'Removed from wishlist!';
        } else {
            self::query()->create([
                'user_id' => $userId,
                'selling_post_id' => $postId,
            ]);
            return 'Added to wishlist!';
        }
    }
}
