<?php

namespace Tests\Unit;

use App\Services\ListingSimilarity;
use App\Services\MarketplaceSearch;
use PHPUnit\Framework\TestCase;

class MarketplaceSearchTest extends TestCase
{
    public function test_it_normalizes_and_limits_search_input(): void
    {
        $this->assertSame('vintage camera lens', MarketplaceSearch::normalize("  VINTAGE   Camera Lens  "));
        $this->assertSame(['sony', 'alpha', 'a7'], MarketplaceSearch::tokens('Sony alpha A7 sony'));
        $this->assertLessThanOrEqual(120, mb_strlen(MarketplaceSearch::normalize(str_repeat('x', 200))));
    }

    public function test_exchange_compatibility_outranks_a_brand_only_match(): void
    {
        $source = ['brand_id' => 1, 'condition' => 'used', 'location' => 'Belgrade', 'categories' => [10], 'wanted_categories' => [20]];
        $brandOnly = ['brand_id' => 1, 'condition' => 'new', 'location' => 'Novi Sad', 'categories' => [30], 'wanted_categories' => []];
        $compatible = ['brand_id' => 2, 'condition' => 'used', 'location' => 'Belgrade', 'categories' => [20], 'wanted_categories' => [10]];

        $this->assertGreaterThan(
            ListingSimilarity::score($source, $brandOnly)['score'],
            ListingSimilarity::score($source, $compatible)['score'],
        );
        $this->assertContains('reciprocal exchange fit', ListingSimilarity::score($source, $compatible)['reasons']);
    }
}
