<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentGatewayRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function showWallet()
    {
        $payment_methods = PaymentGatewayRepository::getAll();
        $transactions = TransactionRepository::query()
            ->with(['user', 'boostPlan', 'payment_method'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $wallet = WalletRepository::query()
            ->where('user_id', auth()->id())
            ->first();

        return view('web.profile.sections.my-wallet', [
            'transactions'    => $transactions,
            'payment_methods' => $payment_methods,
            'wallet' => $wallet,
        ]);
    }


    public function create()
    {
        $payment_methods = PaymentGatewayRepository::getAll();
        return view('web.profile.sections.my-wallet', compact('payment_methods'));
    }


    public function store(Request $request)
    {

        // Generate a unique transaction identifier
        $transactionIdentifier = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 16)), 0, 16);

        // Prepare the data array
        $data = [
            'boost_plan_id' => null,
            'selling_post_id' => null,
            'payment_method_id' => $request->payment_method_id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'amount' => $request->amount,
            'contact' => $request->contact,
            'paid_at' => now(),
            'auto_pay' => $request->boolean('auto_pay'),
            'service_price' => $request->service_price,
            'service_tax' => $request->service_tax,
            'service_total' => $request->service_total,
            'identifier' => $transactionIdentifier,
        ];

        // Store in database
        $transaction = TransactionRepository::create($data);

        // Redirect to payment view with identifier
        return redirect()->route('wallet.payment.views', $transactionIdentifier);
    }

    public function paymentViews($identifier)
    {

        $transaction = TransactionRepository::query()->where('identifier', $identifier)->first();

        $this->paymentService->processPayment($transaction->amount, [
            'gateway' => $transaction->payment_method?->name ?? 'N/A',
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
}
