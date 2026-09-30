<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchKeyRequest;
use App\Models\SearchKey;
use App\Models\SellingPost;
use App\Repositories\SearchKeyRepository;
use App\Repositories\SellingPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchKeyController extends Controller
{

    public function suggest(Request $request)
    {

        $query = $request->get('query');
        if (!$query) return response()->json([]);

        $suggestions = SearchKeyRepository::getSuggestions($query);
        return response()->json($suggestions);
    }


    public function store(SearchKeyRequest $request)
    {
        $searchKey = SearchKeyRepository::storeOrUpdate($request);
    }
}
