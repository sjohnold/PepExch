<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'plan_items' => 'object',
    ];
    public function boostPlan()
    {
        return $this->belongsTo(BoostPlan::class, 'boost_plan_id');
    }
    public function sellingPost()
    {
        return $this->belongsTo(SellingPost::class, 'selling_post_id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_method_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransaction::class, 'wallet_transaction_id');
    }
}
