<?php

namespace App\Http\Controllers;

use App\Models\BoostPost;
use App\Repositories\BoostPostRepository;
use Illuminate\Http\Request;

class BoostPostController extends Controller
{
    public function sold()
    {
        $soldBoosts = BoostPostRepository::query()->with(['boostPlan', 'sellingPost'])
            ->where('expired_at', '<', now())
            ->orWhereHas('sellingPost', fn($q) => $q->where('is_sold', true))
            ->get();

        return view('admin.boosts.posts.sold', compact('soldBoosts'));
    }
}
