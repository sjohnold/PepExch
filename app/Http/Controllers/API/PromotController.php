<?php

namespace App\Http\Controllers\API;

use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\User\UserResource;
use App\Models\Setting;
use App\Repositories\BoostPlanRepository;
use App\Repositories\BoostPostRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Promot API')]
class PromotController extends Controller
{

    /**
     * Get BoostPlan
     *
     */
    public function boostplan()
    {
        $boostPlans = BoostPlanRepository::getAll();

        return $this->json('All Boost Plans fetched successfully.', [
            'boost_plans' => $boostPlans
        ], 200);
    }


    /**
     *  Checkout
     *
     */

    #[BodyParameter('boost_plan_id', required: false, type: 'string', example: '1')]
    #[BodyParameter('selling_post_id', required: false, type: 'string', example: '123')]
    #[BodyParameter('payment_gateway_id', required: false, type: 'string', example: '1' / '')]
    #[BodyParameter('user_id', required: true, type: 'string', example: '1')]
    #[BodyParameter('name', required: true, type: 'string', example: 'razak')]
    #[BodyParameter('email', required: true, type: 'string', example: 'abc@gmail.com')]
    #[BodyParameter('phone', required: true, type: 'string', example: '017**********')]
    #[BodyParameter('is_wallet', required: false, type: 'string', example: '0')]

    public function checkoutApi(Request $request)
    {

        if (!$request->payment_gateway_id && !$request->is_wallet) {
            return $this->json('Please select payment method', null, 422);
        }



        if ($request->payment_gateway_id && !$request->is_wallet) {
            $gateway = PaymentGatewayRepository::query()->find($request->payment_gateway_id);

            if ($gateway && strtolower($gateway->name) === 'stripe') {
                $amount = $request->service_total ?? $request->amount;
                $currency = config('app.currency', 'USD');

                if ($currency !== 'USD' && $currency !== 'EUR' && $amount < 50) {
                    return $this->json('Please pay at least 50 cents for Stripe payment.', null, 422);
                }
            }
        }


        $transactionIdentifier = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 16)), 0, 16);

        $user = Auth::user() ?? Auth::guard('sanctum')->user();


        $data = [
            'boost_plan_id' => $request->boost_plan_id,
            'selling_post_id' => $request->selling_post_id,
            'payment_gateway_id' => $request->payment_gateway_id,
            'user_id' => $request?->user_id ?? $user->id,
            'name' => $request->name ?? $user?->name,
            'email' => $request->email ?? $user?->email,
            'contact' => $request->contact ?? $user?->phone_no,
            'auto_pay' => $request->auto_pay ?? false,
            'service_price' => $request->service_price,
            'service_tax' => $request->service_tax,
            'service_total' => $request->service_total ?? $request->amount,
            'identifier' => $transactionIdentifier,
        ];
        // Store via Repository
        $transaction = TransactionRepository::storeByRequest($data);

        //  If wallet, handle immediately
        if ($request->is_wallet == 1) {
            return $this->walletManagement($transactionIdentifier);
        }

        return $this->json('checkout success', [
            'payment_url' => route('payment.view', $transactionIdentifier)
        ], 200);
    }

    public function walletManagement($identifier)
    {

        // Find the transaction
        $transaction = TransactionRepository::query()->where('identifier', $identifier)->first();
        if (!$transaction) {
            return back()->withError('Transaction not found');
        }

        // Find user's wallet
        $wallet = WalletRepository::query()->where('user_id', $transaction->user_id)->first();

        // dd($wallet);
        if (!$wallet || $wallet->balance < $transaction->amount) {
            return $this->json('Insufficient wallet balance.', 'null', 200);
            // return back()->withError('Insufficient wallet balance.');
        }

        // Deduct the amount
        $wallet->balance -= $transaction->amount;
        $wallet->save();

        // Record wallet transaction
        $walletTxn = WalletTransactionRepository::create([
            'wallet_id' => $wallet->id,
            'type' => 'debit',
            'amount' => $transaction->amount,
            'transaction_id' => $transaction->identifier,
            'note' => 'Payment deducted for purchase',
            'balance_after' => $wallet->balance,
        ]);

        // Mark transaction as paid
        $transaction->update([
            'is_paid' => true,
            'status' => 'complete',
            'paid_at' => now(),
            'wallet_transaction_id' => $walletTxn->id
        ]);




        $boostPlan = $transaction->boostPlan;

        BoostPostRepository::query()->firstOrCreate(
            ['selling_post_id' => $transaction->selling_post_id],
            [
                'boost_plan_id' => $transaction->boost_plan_id,
                'auto_pay' => $transaction->auto_pay,
                'expired_at' => $boostPlan ? now()->addDays($boostPlan->sustain_days) : null,
            ]
        );

        $user = $transaction->user;
        $senderId = $user->id;

        // Admin Notification
        $receiverIds = null;
        $senderId =  $senderId;
        $adminSubject = "Product Boosted by" . $user->name;
        $adminBody = $user->name . " has boosted a product. An amount of " . currencyFormat($transaction->amount) . " has been added to your account.";


        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $adminSubject,
            $adminBody
        );

        // User Notification
        $receiverIds = $user->id;
        $senderId =  $senderId;
        $subject = "Your product has been Boosted..!!";
        $body = "Your product has been successfully boosted. An amount of " . currencyFormat($transaction->amount) . " has been deducted from your wallet.";


        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );

        return $this->json('Payment successful! Amount deducted from your wallet.', 200);
    }
}
