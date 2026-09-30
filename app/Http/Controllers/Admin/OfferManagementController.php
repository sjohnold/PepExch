<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferManagementController extends Controller
{
    /**
     * Display a listing of all barter offers for admin moderation.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Offer::with(['sender', 'receiver', 'sellingPost'])
            ->latest();

        if ($status && in_array($status, ['pending', 'accepted', 'rejected', 'withdrawn', 'completed'])) {
            $query->where('status', $status);
        }

        $offers = $query->paginate(20);

        $stats = [
            'total' => Offer::count(),
            'pending' => Offer::where('status', 'pending')->count(),
            'accepted' => Offer::where('status', 'accepted')->count(),
            'completed' => Offer::where('status', 'completed')->count(),
            'rejected' => Offer::where('status', 'rejected')->count(),
        ];

        return view('admin.offers.index', compact('offers', 'stats', 'status'));
    }

    /**
     * Show a single offer detail.
     */
    public function show(Offer $offer)
    {
        $offer->load(['sender', 'receiver', 'sellingPost']);

        $conversationIds = Conversation::query()
            ->where(function ($query) use ($offer) {
                $query->where('sender_id', $offer->sender_id)
                    ->where('receiver_id', $offer->receiver_id);
            })
            ->orWhere(function ($query) use ($offer) {
                $query->where('sender_id', $offer->receiver_id)
                    ->where('receiver_id', $offer->sender_id);
            })
            ->pluck('id');

        $messages = Message::query()
            ->with(['sender', 'receiver', 'thumbnails', 'offer', 'sellingPost'])
            ->where(function ($query) use ($offer, $conversationIds) {
                $query->where('offer_id', $offer->id);

                if ($conversationIds->isNotEmpty()) {
                    $query->orWhereIn('conversation_id', $conversationIds);
                }
            })
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        return view('admin.offers.show', compact('offer', 'messages'));
    }

    /**
     * Delete an offer record from the admin panel.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return back()->with('success', 'Offer deleted successfully.');
    }

    /**
     * Force-cancel an offer (admin intervention).
     */
    public function forceCancel(Offer $offer)
    {
        if (in_array($offer->status, ['completed'])) {
            return back()->with('error', 'Cannot cancel a completed offer.');
        }

        $offer->update(['status' => 'withdrawn']);
        return back()->with('success', 'Offer force-cancelled successfully.');
    }
}
