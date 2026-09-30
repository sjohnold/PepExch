<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\BoostPlan;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\PostView;
use App\Models\SellingPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class SellingPostSeeder extends Seeder
{

    public function run(): void
    {
        $userIds      = User::pluck('id')->toArray();
        $brandIds     = Brand::pluck('id')->toArray();
        $categoryIds  = Category::pluck('id')->toArray();
        $mediaIds     = Media::pluck('id')->toArray();
        $attributeIds = Attribute::pluck('id')->toArray();
        $boostPlans   = BoostPlan::pluck('id')->toArray();

        // Create 10 simple posts
        for ($i = 1; $i <= 10; $i++) {

            $post = SellingPost::create([
                'name'            => "Post $i",
                'conditions'      => "Used",
                'asking_price'    => rand(1000, 50000),
                'sold_price'      => null,
                'contact_number'  => "017" . rand(10000000, 99999999),
                'email'           => "post$i@example.com",
                'description'     => "Description for post $i",
                'latitude'        => null,
                'longitude'       => null,
                'warranty_left'   => null,
                'model'           => "Model-$i",
                'color_code'      => "#" . dechex(rand(111111, 999999)),
                'number_of_view'  => 0,
                'status'          => "Approve",
                'is_sold'         => false,
                'is_negotiable'   => true,
                'media_id'        => !empty($mediaIds) ? collect($mediaIds)->random() : null,
                'user_id'         => !empty($userIds) ? collect($userIds)->random() : null,
                'brand_id'        => !empty($brandIds) ? collect($brandIds)->random() : null,
            ]);

            /**
             * Add Thumbnails
             */
            if (!empty($mediaIds)) {
                $thumbs = collect($mediaIds)->random(2);

                // First = default
                $post->thumbnails()->attach($thumbs[0], ['default' => true]);

                // Second = not default
                $post->thumbnails()->attach($thumbs[1], ['default' => false]);
            }

            /**
             * Add Categories
             */
            if (!empty($categoryIds)) {
                $post->categories()->attach(collect($categoryIds)->random(rand(1, 3)));
            }

            /**
             * Add Attributes
             */
            if (!empty($attributeIds)) {
                $post->attributes()->attach(collect($attributeIds)->random(rand(1, 3)));
            }

            /**
             * Add Boost Plan
             */
            if (!empty($boostPlans)) {
                $post->boosts()->attach(
                    collect($boostPlans)->random(),
                    ['expired_at' => now()->addDays(rand(3, 7))]
                );
            }

            /**
             * Add Post Views (simple)
             */
            $viewCount = rand(5, 20);
            $usedIPs = []; // track IPs for this post only

            for ($v = 0; $v < $viewCount; $v++) {

                // keep generating until we get a unique IP
                do {
                    $ip = "192.168.0." . rand(1, 200);
                } while (in_array($ip, $usedIPs));

                // store the IP so it doesn't repeat
                $usedIPs[] = $ip;

                PostView::create([
                    'selling_post_id' => $post->id,
                    'ip_address'      => $ip,
                    'user_id'         => null,
                ]);
            }

            // Update view count
            $post->number_of_view = $viewCount;
            $post->save();
        }
    }
}
