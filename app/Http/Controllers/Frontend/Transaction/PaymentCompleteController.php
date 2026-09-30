<?php

namespace App\Http\Controllers\Frontend\Transaction;

use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Models\BoostPost;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\BoostPostRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;


class PaymentCompleteController extends Controller
{
    public function paypalPaymentSuccess(Request $request, string $identifier)
    {
        // Decode the identifier
        $decodedIdentifier = base64_decode($identifier);

        // Find the transaction
        $transaction = TransactionRepository::query()
            ->where('identifier', $decodedIdentifier)
            ->first();

        if (!$transaction) {
            return redirect()->route('user.my-ads')->with('error', 'Transaction not found.');
        }

        // Decide where to redirect
        if (is_null($transaction->selling_post_id) && is_null($transaction->boost_plan_id)) {
            // Wallet recharge
            return $this->walletManagement($identifier);
        } else {
            // Regular purchase/boost
            return $this->transactionManagement($identifier);
        }
    }
    public function paypalPaymentCancel()
    {
        return $this->fail();
    }

    public function stripePaymentSuccess(string $identifier)
    {
        // Decode the identifier
        $decodedIdentifier = base64_decode($identifier);

        // Find the transaction
        $transaction = TransactionRepository::query()
            ->where('identifier', $decodedIdentifier)
            ->first();

        if (!$transaction) {
            return redirect()->route('user.my-ads')->with('error', 'Transaction not found.');
        }

        // Decide where to redirect
        if (is_null($transaction->selling_post_id) && is_null($transaction->boost_plan_id)) {
            // Wallet recharge
            return $this->walletManagement($identifier);
        } else {
            // Regular purchase/boost
            return $this->transactionManagement($identifier);
        }
    }


    public function stripePaymentCancel()
    {
        return $this->fail();
    }

    public function aamarpayPaymentSuccess(Request $request)
    {
        // Extract the transaction ID from the request
        $request_id = $request->mer_txnid;

        // Construct the URL to check the transaction status
        $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php"
            . "?request_id=$request_id"
            . "&store_id=aamarpaytest"
            . "&signature_key=dbb74894e82415a2f7ff0ec3a97e4183"
            . "&type=json";

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            )
        );

        // Execute the cURL request and get the response
        $response = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        $user =  User::where('email', request()->cus_email)->first();

        Auth::login($user);

        $decodedIdentifier = base64_decode($request_id);

        $transaction = TransactionRepository::query()
            ->where('identifier', $decodedIdentifier)
            ->first();

        if (!$transaction) {
            return back()->withError('Transaction not found');
        }


        if (is_null($transaction->selling_post_id) && is_null($transaction->boost_plan_id)) {
            return $this->walletManagement($request->mer_txnid);
        } else {
            return $this->transactionManagement($request->mer_txnid);
        }
    }

    public function aamarpayPaymentCancel()
    {
        return $this->fail();
    }

    public function aamarpayPaymentFail(Request $request)
    {

        return $this->fail();
    }


    public function transactionManagement($identifier)
    {
        // Decode if needed (you can adjust this part)
        $decodedIdentifier = base64_decode($identifier);

        // Find the transaction by identifier
        $transaction = TransactionRepository::query()->where('identifier', $decodedIdentifier)->first();

        if (!$transaction) {
            return back()->withError('Transaction not found');
        }

        // Update fields
        $transaction->update([
            'is_paid' => true,
            'status' => 'complete',
            'paid_at' => Carbon::now(),
        ]);

        BoostPostRepository::query()->updateOrCreate(
            ['selling_post_id' => $transaction->selling_post_id],
            [
                'boost_plan_id' => $transaction->boost_plan_id,
                'expired_at' => now()->addDays($transaction->boostPlan->sustain_days),
            ]
        );


        return $this->json('payment success', null, 200);
    }

    public function fail()
    {
        return $this->json('Payment Process Fail', 401);
    }

    public function walletManagement($identifier)
    {
        // If identifier is base64 encoded, decode it
        $decodedIdentifier = base64_decode($identifier) ?: $identifier;

        // Find transaction
        $transaction = TransactionRepository::query()
            ->where('identifier', $decodedIdentifier)
            ->first();

        if (!$transaction) {
            return back()->withError('Transaction not found');
        }

        // Find or create wallet
        $wallet = WalletRepository::query()->firstOrCreate(
            ['user_id' => $transaction->user_id],
            ['balance' => 0],
        );

        // Update wallet balance
        $wallet->balance += $transaction->amount;
        $wallet->save();

        // Check if wallet transaction already recorded
        $existingTxn = WalletTransactionRepository::query()
            ->where('transaction_id', $transaction->identifier)
            ->first();

        if (!$existingTxn) {

            // Record wallet credit transaction
            $walletTxn = WalletTransactionRepository::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $transaction->amount,
                'transaction_id' => $transaction->identifier,
                'note' => 'Wallet recharge successful',
                'balance_after' => $wallet->balance,
            ]);

            // Link wallet transaction to main transaction
            $transaction->update([
                'is_paid' => true,
                'status' => 'complete',
                'wallet_transaction_id' => $walletTxn->id,
                'paid_at' => now(),
            ]);

            // Notification
            $receiverIds = [null, $transaction->user_id];
            $senderId = $transaction->user_id;
            $subject = "Wallet Recharged Successfully!";
            $body = "An amount of " . currencyFormat($transaction->amount) . " has been added to your wallet.";

            NotifyManagementEvent::dispatch(
                $receiverIds,
                $senderId,
                $subject,
                $body
            );

            return $this->json('Payment successful! Amount added to your wallet.', null, 200);
        }
        return $this->json('Not Enough Money In Your Wallet', null, 200);
    }
}
