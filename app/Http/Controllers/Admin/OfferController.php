<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $offers = Offer::with(['sender', 'receiver', 'sellingPost'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('sellingPost', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('sender', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.offers.index', compact('offers', 'status'));
    }

    public function show($id)
    {
        $offer = Offer::with(['sender', 'receiver', 'sellingPost'])->findOrFail($id);
        return view('admin.offers.show', compact('offer'));
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return back()->with('success', 'Offer deleted successfully.');
    }
}
