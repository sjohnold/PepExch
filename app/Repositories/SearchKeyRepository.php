<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\SearchKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SearchKeyRepository extends Repository
{
    public static function model()
    {
        return SearchKey::class;
    }


    public static function getSuggestions($query)
    {
        return self::query()
            ->where('value', 'LIKE', "%{$query}%")
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return Str::limit($item->value, 50);
            });
    }



    public static function storeOrUpdate($request)
    {
        $userId = Auth::check() && Auth::guard('api')->check()
            ? Auth::guard('api')->user()->id
            : Auth::id();

        // Get the search value safely
        $value = $request->query('query') ?? $request->input('query') ??  $request->input('product_search') ?? $request->input('search_key');

        if (empty($value)) {
            Log::warning('Empty search value', ['user_id' => $userId, 'input' => $request->all()]);
            return;
        }

        $existing = self::query()
            ->where('user_id', $userId)
            ->where('value', $value)
            ->first();

        if ($existing) {
            return $existing->touch();
        } else {
            return self::create([
                'user_id' => $userId,
                'value' => $value,
            ]);
        }
    }
}
