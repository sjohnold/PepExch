<?php

namespace App\Services;

class ListingSimilarity
{
    /**
     * Explainable item-to-item relevance score used by the recommendation layer.
     * Inputs are deliberately simple so ranking can be unit-tested independently.
     *
     * @return array{score:int,reasons:list<string>}
     */
    public static function score(array $source, array $candidate): array
    {
        $score = 0;
        $reasons = [];
        $sourceCategories = array_map('intval', $source['categories'] ?? []);
        $candidateCategories = array_map('intval', $candidate['categories'] ?? []);
        $sharedCategories = array_intersect($sourceCategories, $candidateCategories);

        if ($sharedCategories !== []) {
            $score += min(45, count($sharedCategories) * 25);
            $reasons[] = 'shared category';
        }

        if (!empty($source['brand_id']) && $source['brand_id'] === ($candidate['brand_id'] ?? null)) {
            $score += 20;
            $reasons[] = 'same brand';
        }

        if (!empty($source['condition']) && $source['condition'] === ($candidate['condition'] ?? null)) {
            $score += 10;
            $reasons[] = 'same condition';
        }

        if (!empty($source['location']) && mb_strtolower($source['location']) === mb_strtolower((string) ($candidate['location'] ?? ''))) {
            $score += 10;
            $reasons[] = 'same location';
        }

        $sourceWants = array_map('intval', $source['wanted_categories'] ?? []);
        $candidateWants = array_map('intval', $candidate['wanted_categories'] ?? []);

        if (array_intersect($sourceWants, $candidateCategories) !== []) {
            $score += 20;
            $reasons[] = 'matches exchange preference';
        }

        if (array_intersect($candidateWants, $sourceCategories) !== []) {
            $score += 15;
            $reasons[] = 'reciprocal exchange fit';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }
}
