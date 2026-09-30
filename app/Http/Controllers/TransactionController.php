<?php

namespace App\Http\Controllers;

use App\Events\NotifyManagementEvent;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Setting;
use App\Repositories\BoostPlanRepository;
use App\Repositories\BoostPostRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function index($status = null)
    {
        $transactions = TransactionRepository::getByStatus($status);
        return view('admin.transactions.index', compact('transactions', 'status'));
    }
    // for frontend
    public function checkout(Request $request)
    {

        $user = auth()->user();
        $boostPlanId = $request->boost_plan_id;
        $boostPlan = BoostPlanRepository::query()->findOrFail($boostPlanId);
        $paymentGateways = PaymentGatewayRepository::getAll();
        $allBoostPlans = BoostPlanRepository::query()->get();
        $taxSetting = Setting::where('type', 'Tax')->first();
        $taxData = $taxSetting ? json_decode($taxSetting->data) : null;
        $post = SellingPostRepository::find($request->product_id);
        return view('web.profile.sections.checkout', compact('user', 'boostPlan', 'paymentGateways', 'allBoostPlans', 'taxData', 'post'));
    }


    public function store(StoreTransactionRequest $request)
    {
        try {
            $transactionIdentifier = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 16)), 0, 16);

            $data = [
                'boost_plan_id' => $request->boost_plan_id,
                'selling_post_id' => $request->selling_post_id,
                'payment_gateway_id' => $request->payment_gateway_id,
                'wallet_transaction_id' => $request->wallet_transaction_id ?? null,
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'auto_pay' => $request->auto_pay,
                'service_price' => $request->service_price,
                'service_tax' => $request->service_tax,
                'service_total' => $request->service_total,
                'identifier' => $transactionIdentifier,
            ];
            // Store via Repository
            $transaction = TransactionRepository::storeByRequest($data);


            //  If wallet, handle immediately
            if ($request->payment_gateway_id === null) {
                return $this->walletManagement($transactionIdentifier);
            }

            return redirect()->route('payment.view', $transactionIdentifier);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }




    public function paymenthistory()
    {

        $transactions = TransactionRepository::query()->with(['user', 'boostPlan', 'payment_method'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(5);

        return view('web.profile.sections.payment-history', compact('transactions'));
    }


    public function paymentView($identifier)
    {

        $transaction = TransactionRepository::query()->where('identifier', $identifier)->first();
        $this->paymentService->processPayment($transaction->amount, [
            'gateway' => $transaction->payment_method->name ?? 'N/A',
            'identifier' => base64_encode($transaction->identifier),
            'product' => [
                'product' => $transaction->sellingPost->name ?? 'N/A',
                'price' => $transaction->amount,
                'images' => $transaction->course->mediaPath ?? 'https://placehold.co/600x400'
            ],
            'customer' => [
                'name' => $transaction->user?->name ?? 'N/A',
                'email' => $transaction->user?->email ?? 'N/A',
                'phone' => $transaction->user?->phone ?? 'N/A',
            ]
        ]);
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


        if (!$wallet || $wallet->balance < $transaction->amount) {
            return back()->withError('Insufficient wallet balance.');
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


        //  Activate Boost
        BoostPostRepository::query()->firstOrCreate([
            'selling_post_id' => $transaction->selling_post_id
        ], [
            'boost_plan_id' => $transaction->boost_plan_id,
            'auto_pay' => $transaction->auto_pay,
            'expired_at'    => now()->addDays($transaction->boostPlan->sustain_days),
        ]);



        $user = auth()->user();
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

        return redirect()
            ->route('user.my-wallet')
            ->with('success', 'Payment successful! Amount deducted from your wallet.');
    }

    public function wallet()
    {
        $transactions = TransactionRepository::query()->whereNotNull('boost_plan_id')
            ->whereNotNull('selling_post_id')
            ->whereNull('payment_method_id')
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }
    public function walletRecherge()
    {
        $transactions = TransactionRepository::query()->whereNull('boost_plan_id')
            ->whereNull('selling_post_id')
            ->whereNotNull('payment_method_id')
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    // Direct Boost Purchase
    public function boost()
    {
        $transactions = TransactionRepository::query()->whereNotNull('boost_plan_id')
            ->whereNotNull('selling_post_id')
            ->whereNotNull('payment_method_id')
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

public function autoPay(Request $request)
{
    $boostPost = BoostPostRepository::query()
        ->where('selling_post_id', $request->selling_post_id)
        ->first();

    if (!$boostPost) {
        return back()->with('error', 'Boost post not found');
    }

    $boostPost->update([
        'auto_pay' => $boostPost->auto_pay == 1 ? 0 : 1,
        'updated_at' => now()
    ]);

    return back()->with('success', 'Auto Pay status updated');
}

}
