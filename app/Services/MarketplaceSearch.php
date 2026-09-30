<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class MarketplaceSearch
{
    /**
     * Apply a portable, weighted relevance score. The expression works on both
     * MySQL and SQLite, which keeps local development and CI deterministic.
     */
    public function apply(Builder $query, ?string $input): Builder
    {
        $term = self::normalize($input);

        if ($term === '') {
            return $query;
        }

        $tokens = self::tokens($term);
        $query->where(function (Builder $match) use ($term, $tokens) {
            $match->whereRaw('LOWER(name) LIKE ?', ['%'.$term.'%'])
                ->orWhereRaw('LOWER(description) LIKE ?', ['%'.$term.'%'])
                ->orWhereRaw('LOWER(COALESCE(model, \'\')) LIKE ?', ['%'.$term.'%'])
                ->orWhereRaw('LOWER(COALESCE(location, \'\')) LIKE ?', ['%'.$term.'%'])
                ->orWhereHas('brand', fn (Builder $brand) => $brand
                    ->whereRaw('LOWER(name) LIKE ?', ['%'.$term.'%']))
                ->orWhereHas('categories', fn (Builder $category) => $category
                    ->whereRaw('LOWER(name) LIKE ?', ['%'.$term.'%']));

            foreach ($tokens as $token) {
                $match->orWhereRaw('LOWER(name) LIKE ?', ['%'.$token.'%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%'.$token.'%']);
            }
        });

        $score = [];
        $bindings = [];
        $this->score($score, $bindings, 'LOWER(name) = ?', $term, 120);
        $this->score($score, $bindings, 'LOWER(name) LIKE ?', $term.'%', 70);
        $this->score($score, $bindings, 'LOWER(name) LIKE ?', '%'.$term.'%', 45);
        $this->score($score, $bindings, 'LOWER(COALESCE(model, \'\')) LIKE ?', '%'.$term.'%', 24);
        $this->score($score, $bindings, 'LOWER(description) LIKE ?', '%'.$term.'%', 14);
        $this->score($score, $bindings, 'LOWER(COALESCE(location, \'\')) LIKE ?', '%'.$term.'%', 8);

        foreach ($tokens as $token) {
            $this->score($score, $bindings, 'LOWER(name) LIKE ?', '%'.$token.'%', 12);
            $this->score($score, $bindings, 'LOWER(description) LIKE ?', '%'.$token.'%', 4);
        }

        return $query
            ->select('selling_posts.*')
            ->selectRaw(implode(' + ', $score).' AS search_score', $bindings)
            ->orderByDesc('search_score');
    }

    public static function normalize(?string $input): string
    {
        $value = mb_strtolower(trim((string) $input));
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';

        return mb_substr($value, 0, 120);
    }

    /** @return list<string> */
    public static function tokens(?string $input): array
    {
        $normalized = self::normalize($input);
        preg_match_all('/[\p{L}\p{N}]{2,}/u', $normalized, $matches);

        return array_values(array_unique(array_slice($matches[0] ?? [], 0, 8)));
    }

    /** @param list<string> $parts @param list<string> $bindings */
    private function score(array &$parts, array &$bindings, string $condition, string $value, int $weight): void
    {
        $parts[] = "CASE WHEN {$condition} THEN {$weight} ELSE 0 END";
        $bindings[] = $value;
    }
}
