<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\BoostPostRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletTransactionRepository;
use Carbon\Carbon;

class AutoPayBoost extends Command
{
    protected $signature = 'boost:autopay';
    protected $description = 'Automatically pay for boost posts if auto_pay is enabled and expired';

    public function handle()
    {
        // only expired BoostPost fetch
        $boostPosts = BoostPostRepository::query()
            ->where('auto_pay', true)
            ->where('expired_at', '<=', Carbon::now())
            ->with(['sellingPost.user', 'boostPlan'])
            ->get();

        $this->info("Total boost posts eligible for auto-pay: " . $boostPosts->count());

        foreach ($boostPosts as $boostPost) {

            
            $user = $boostPost->sellingPost?->user;
            if (!$user) {
                $this->info("BoostPost ID {$boostPost->id} has no user via SellingPost, skipping.");
                continue;
            }

            // Wallet check
            $wallet = $user->wallet;
            if (!$wallet) {
                $this->info("User ID {$user->id} has no wallet, skipping.");
                continue;
            }

            // BoostPlan price
            $amount = $boostPost->boostPlan?->payable_amount ?? 0;
            if ($amount <= 0) {
                $this->info("BoostPlan ID {$boostPost->boost_plan_id} has zero amount, skipping.");
                continue;
            }

            $this->info("Processing BoostPost ID {$boostPost->id} | User ID: {$user->id} | Wallet balance: {$wallet->balance} | Amount: {$amount}");

            if ($wallet->balance < $amount) {
                $this->info("Insufficient wallet for User ID {$user->id}, skipping.");
                continue;
            }

            // Transaction create
            $transactionIdentifier = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 16);
            $transaction = TransactionRepository::storeByRequest([
                'boost_plan_id' => $boostPost->boost_plan_id,
                'selling_post_id' => $boostPost->selling_post_id,
                'payment_gateway_id' => null,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->phone_no,
                'auto_pay' => true,
                'service_price' => $amount,
                'service_tax' => 0,
                'service_total' => $amount,
                'identifier' => $transactionIdentifier,
            ]);

            // Wallet deduct
            $wallet->balance -= $amount;
            $wallet->save();

            // WalletTransaction record
            WalletTransactionRepository::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'transaction_id' => $transactionIdentifier,
                'note' => 'Auto-pay for BoostPost ID ' . $boostPost->id,
                'balance_after' => $wallet->balance,
            ]);

            // Transaction update
            $transaction->update([
                'is_paid' => true,
                'status' => 'complete',
                'paid_at' => Carbon::now(),
            ]);

            // BoostPost create or update
            BoostPostRepository::query()->updateOrCreate(
                ['selling_post_id' => $boostPost->selling_post_id],
                [
                    'boost_plan_id' => $boostPost->boost_plan_id,
                    'auto_pay' => true,
                    'expired_at' => Carbon::now()->addDays($boostPost->boostPlan?->sustain_days ?? 7),
                ]
            );

            $this->info("Auto-paid BoostPost ID {$boostPost->id} (User ID: {$user->id})");
        }

        $this->info("Auto-pay process completed.");
    }
}
