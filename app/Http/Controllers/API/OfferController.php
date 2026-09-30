<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ConfirmExchangeRequest;
use App\Http\Requests\Api\StoreOfferRequest;
use App\Http\Requests\Api\UpdateOfferStatusRequest;
use App\Models\Offer;
use App\Models\SellingPost;
use App\Services\EscrowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class OfferController extends Controller
{
    protected EscrowService $escrowService;

    public function __construct(EscrowService $escrowService)
    {
        $this->escrowService = $escrowService;
    }

    /**
     * Display a listing of offers for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $sent = $user->sentOffers()->with('sellingPost', 'receiver')->latest()->get();
        $received = $user->receivedOffers()->with('sellingPost', 'sender')->latest()->get();

        return response()->json([
            'sent' => $sent,
            'received' => $received,
        ]);
    }

    /**
     * Store a newly created offer.
     */
    public function store(StoreOfferRequest $request): JsonResponse
    {
        $post = SellingPost::findOrFail($request->selling_post_id);

        if ($post->user_id === $request->user()->id) {
            return response()->json(['message' => 'You cannot offer to your own post.'], 403);
        }

        try {
            $offer = $this->escrowService->createOffer([
                'sender_id' => $request->user()->id,
                'receiver_id' => $post->user_id,
                'selling_post_id' => $post->id,
                'sender_items' => $request->sender_items,
                'receiver_items' => $request->receiver_items,
            ]);

            return response()->json([
                'message' => 'Offer created successfully.',
                'offer' => $offer->load('sellingPost', 'receiver'),
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update the offer status (accept/reject/withdraw).
     */
    public function updateStatus(UpdateOfferStatusRequest $request, Offer $offer): JsonResponse
    {
        try {
            $this->escrowService->changeStatus($offer, $request->status, $request->user()->id);
            
            return response()->json([
                'message' => "Offer {$request->status} successfully.",
                'offer' => $offer->fresh(['sellingPost', 'sender', 'receiver']),
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Confirm the exchange completion.
     */
    public function confirm(ConfirmExchangeRequest $request, Offer $offer): JsonResponse
    {
        try {
            $this->escrowService->confirmExchange($offer, $request->user()->id);
            
            $offer = $offer->fresh(['sellingPost', 'sender', 'receiver']);
            
            return response()->json([
                'message' => $offer->status === 'completed' ? 'Exchange completed!' : 'Exchange confirmed from your side.',
                'offer' => $offer,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified offer.
     */
    public function show(Offer $offer, Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        
        if ($offer->sender_id !== $userId && $offer->receiver_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json($offer->load('sellingPost', 'sender', 'receiver'));
    }
}
