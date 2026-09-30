<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Transaction;

class TransactionRepository extends Repository
{
    public static function model()
    {
        return Transaction::class;
    }


    public static function getByStatus($status = null, $perPage = 15)
    {
        return self::query()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public static function countByStatus($status = null)
    {
        return self::query()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    public static function storeByRequest(array $data): Transaction
    {
        $transaction = new Transaction();

        $transaction->user_id = $data['user_id'];
        $transaction->selling_post_id = $data['selling_post_id'] ?? null;
        $transaction->boost_plan_id = $data['boost_plan_id'] ?? null;
        $transaction->payment_method_id = $data['payment_gateway_id'] ?? null;
        $transaction->wallet_transaction_id = $data['wallet_transaction_id'] ?? null;
        $transaction->name = $data['name'];
        $transaction->email = $data['email'];
        $transaction->contact = $data['contact'];
        $transaction->auto_pay = $data['auto_pay'];

        $transaction->amount = $data['service_total'];
        $transaction->identifier = $data['identifier'];
        $transaction->status = 'pending';
        $transaction->is_paid = false;
        $transaction->paid_at = now();

        $transaction->save();

        return $transaction;
    }
    public static function currentMonthEarnings()
    {
        return self::query()
            ->where('status', 'complete')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
    }

    public static function lastMonthEarnings()
    {
        return self::query()
            ->where('status', 'complete')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('amount');
    }

    public static function earningGrowthRate()
    {
        $current = self::currentMonthEarnings();
        $previous = self::lastMonthEarnings();

        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public static function totalEarnings()
    {
        return self::query()
            ->where('status', 'complete')
            ->whereNotNull('payment_method_id')
            ->sum('amount');
    }

    // Wallet Recharge Only
    public static function totalWalletRecharge()
    {
        return self::query()
            ->where('status', 'complete')
            ->whereNull('selling_post_id')
            ->whereNull('boost_plan_id')
            ->whereNotNull('payment_method_id')
            ->sum('amount');
    }

    // Direct Purchase + Boost Earnings
    public static function totalDirectPurchaseEarnings()
    {
        return self::query()
            ->where('status', 'complete')
            ->whereNotNull('selling_post_id')
            ->whereNotNull('boost_plan_id')
            ->whereNotNull('payment_method_id')
            ->sum('amount');
    }
    public static function totalPendingPayments()
    {
        return self::query()
            ->where('status', 'pending')
            ->sum('amount');
    }
}
