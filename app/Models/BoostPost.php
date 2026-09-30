<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostPost extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sellingPost()
    {
        return $this->belongsTo(SellingPost::class, 'selling_post_id');
    }

    public function boostPlan()
    {
        return $this->belongsTo(BoostPlan::class, 'boost_plan_id');
    }
    
}
