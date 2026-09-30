<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    /**
     * Export the offer receipt as PDF.
     */
    public function exportReceipt(Offer $offer, Request $request)
    {
        $userId = $request->user()->id;

        // Security check: only parties of the offer can export
        if ($offer->sender_id !== $userId && $offer->receiver_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        // Status check: only completed offers have receipts
        if ($offer->status !== 'completed') {
            return response()->json(['message' => 'Only completed offers can have receipts.'], 422);
        }

        $offer->load(['sender', 'receiver', 'sellingPost']);

        $pdf = Pdf::loadView('pdf.receipt', compact('offer'));

        return $pdf->download("pepexch_receipt_{$offer->id}.pdf");
    }
}
