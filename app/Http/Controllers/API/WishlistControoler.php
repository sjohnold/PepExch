<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\SellingPostRepository;
use App\Repositories\WishlistRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Wishlist API')]
class WishlistControoler extends Controller
{
    /**
     * Get Wishlist
     *
     */
    public function index(Request $request)
    {

        $user = Auth::user() ?? Auth::guard('api')->user();

        if ($user) {
            $wishlistIds = WishlistRepository::query()->where('user_id', $user->id)
                ->pluck('selling_post_id')
                ->toArray();
            $isGuest = false;
        } else {
            return $this->json("You Are Unauthenticate", []);
        }

        $products = SellingPostRepository::query()
            ->whereIn('id', $wishlistIds)
            ->with(['user', 'brand', 'thumbnails'])
            ->get();

        return $this->json("Wishlist fetched successfully", [
            "wishlistIds" => $wishlistIds,
            "products" => ProductResource::collection($products),
            "isGuest" => $isGuest
        ]);
    }


    /**
     * Toggle Wishlist
     *
     */
    #[BodyParameter('selling_post_id', required: true, type: 'string', example: '22')]
    public function toggle(Request $request)
    {
        $postId = intval($request->selling_post_id);

        if (!$postId) {
            return response()->json([
                'message' => 'selling_post_id is required'
            ], 422);
        }

        $status = '';
        $count = 0;

        // API authenticated user
        $user = Auth::user() ?? Auth::guard('api')->user();

        if ($user) {

            $userId = $user->id;

            $exists = WishlistRepository::query()->where('user_id', $userId)
                ->where('selling_post_id', $postId)
                ->exists();

            if ($exists) {
                WishlistRepository::query()->where('user_id', $userId)
                    ->where('selling_post_id', $postId)
                    ->delete();

                $status = 'removed';
            } else {
                WishlistRepository::query()->create([
                    'user_id' => $userId,
                    'selling_post_id' => $postId,
                ]);

                $status = 'added';
            }

            $count = WishlistRepository::query()->where('user_id', $userId)->count();
        } else {
            return $this->json("Something Wrong", []);
        }


        return $this->json('Wishlist updated', [
            'status' => $status,
            'product' => $postId,
            'count' => $count

        ]);
    }
}
