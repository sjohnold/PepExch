<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\SellingPostRepository;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Filter Item API')]
class FilterController extends Controller
{
    /**
     * Get Filters Item
     *
     */
    public function filter(Request $request)
    {
        $perPage = $request->input('items_per_page', 10);
        $conditionsPage = $request->input('conditions_page', 1);
        $locationsPage = $request->input('locations_page', 1);
        $brandsPage = $request->input('brands_page', 1);

        // --- Conditions ---
        $conditions = SellingPostRepository::getDistinctConditions();
        $conditionsSkip = ($conditionsPage - 1) * $perPage;
        $paginatedConditions = $conditions->slice($conditionsSkip, $perPage)->values();

        // --- Locations ---
        $locations = SellingPostRepository::getLocationsWithCount()
            ->map(fn($count, $name) => ['name' => $name, 'count' => $count]);
        $locationsSkip = ($locationsPage - 1) * $perPage;
        $paginatedLocations = $locations->slice($locationsSkip, $perPage)->values();

        // --- Brands ---
        $brands = SellingPostRepository::getBrandsWithCount()
            ->map(fn($count, $name) => ['name' => $name, 'count' => $count]);
        $brandsSkip = ($brandsPage - 1) * $perPage;
        $paginatedBrands = $brands->slice($brandsSkip, $perPage)->values();

        $times = [
            ['value' => 'Last 24 hours'],
            ['value' => 'Last 7 days'],
            ['value' => 'Last 30 days'],
            ['value' => 'Today'],
        ];

        return $this->json('Fetch All Filter Items with Pagination', [
            'conditions' => [
                'total_items' => $conditions->count(),
                'page_number' => $conditionsPage,
                'items' => $paginatedConditions,
            ],
            'locations' => [
                'total_items' => $locations->count(),
                'page_number' => $locationsPage,
                'items' => $paginatedLocations,
            ],
            'brands' => [
                'total_items' => $brands->count(),
                'page_number' => $brandsPage,
                'items' => $paginatedBrands,
            ],
            'dates' => $times,
        ]);
    }
}
