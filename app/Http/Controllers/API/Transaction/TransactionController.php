<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\TransactionSummaryResource;
use App\Http\Resources\Profile\TranscationHistoryResource;
use App\Http\Resources\Wallet\WalletTransactionResource;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Transaction')]
class TransactionController extends Controller
{
        /**
     * Treansaction History
     *
     */
    public function paymentHistory(Request $request)
    {

        $perPage = $request->input('items_per_page', 10);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        $transactionsQuery = TransactionRepository::query()
            ->with(['user', 'boostPlan', 'payment_method'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        $total_history_count = $transactionsQuery->count();
        $transactions = $transactionsQuery->skip($skip)->take($perPage)->get();
        $this_page_history_count = $transactions->count();

        $data = [
            'total_history_count' =>  $total_history_count,
            'this_page_history_count' =>  $this_page_history_count,
            'transactions' => TranscationHistoryResource::collection($transactions),
        ];

        return $this->json("Transcation History Fetched Successfully", $data, 200);
    }

    public function walletPaymentHistory()
    {
        $user = Auth::guard('api')->user();

        $transactions = TransactionRepository::query()
            ->whereNotNull('wallet_transaction_id')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->json("Wallet Transaction History Fetched Successfully",[
            'wallet_transactions' => TranscationHistoryResource::collection($transactions),
        ] , 200);
    }

    /**
     * Treansaction History  Summary
     *
     */
    public function paymentSummary($id)
    {

        $transaction = TransactionRepository::query()
            ->with(['user', 'boostPlan', 'payment_method'])
            ->where('id', $id)
            ->where('user_id', auth()->id()) // only for logged-in user
            ->first();

        if (!$transaction) {
            return $this->json("Invalid transaction id.", null, 200);
        }

        return $this->json(
            "Transaction summary fetched successfully",
            TransactionSummaryResource::make($transaction),
            200
        );
    }


}
