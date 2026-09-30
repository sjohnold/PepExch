<?php

namespace App\Services;

use App\Models\SellingPost;
use Illuminate\Support\Collection;

class ListingRecommendation
{
    public function forListing(SellingPost $source, int $limit = 8): Collection
    {
        $source->loadMissing('categories');
        $categoryIds = $source->categories->pluck('id')->map(fn ($id) => (int) $id)->all();
        $wantedCategoryIds = array_map('intval', (array) $source->exchange_categories_json);

        $candidates = SellingPost::query()
            ->with(['user', 'brand', 'thumbnails', 'categories'])
            ->whereKeyNot($source->getKey())
            ->where('status', 'Approve')
            ->where('is_sold', false)
            ->where(function ($query) use ($source, $categoryIds, $wantedCategoryIds) {
                $query->whereRaw('1 = 0');
                $candidateCategoryIds = array_values(array_unique([...$categoryIds, ...$wantedCategoryIds]));
                if ($candidateCategoryIds !== []) {
                    $query->orWhereHas('categories', fn ($categories) => $categories->whereIn('categories.id', $candidateCategoryIds));
                }
                if ($source->brand_id) {
                    $query->orWhere('brand_id', $source->brand_id);
                }
                if ($source->location) {
                    $query->orWhere('location', $source->location);
                }
                foreach ($categoryIds as $categoryId) {
                    $query->orWhereJsonContains('exchange_categories_json', $categoryId);
                }
            })
            ->latest()
            ->limit(60)
            ->get();

        $sourceData = $this->data($source);

        return $candidates
            ->map(function (SellingPost $candidate) use ($sourceData) {
                $result = ListingSimilarity::score($sourceData, $this->data($candidate));
                $candidate->setAttribute('recommendation_score', $result['score']);
                $candidate->setAttribute('recommendation_reasons', $result['reasons']);

                return $candidate;
            })
            ->filter(fn (SellingPost $candidate) => $candidate->recommendation_score > 0)
            ->sort(function (SellingPost $left, SellingPost $right) {
                return [$right->recommendation_score, $right->created_at?->timestamp ?? 0]
                    <=> [$left->recommendation_score, $left->created_at?->timestamp ?? 0];
            })
            ->take($limit)
            ->values();
    }

    private function data(SellingPost $post): array
    {
        return [
            'brand_id' => $post->brand_id,
            'condition' => $post->conditions,
            'location' => $post->location,
            'categories' => $post->categories->pluck('id')->all(),
            'wanted_categories' => (array) $post->exchange_categories_json,
        ];
    }
}
