<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoostPlan extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = ["id"];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'plan_items' => 'array',
    ];
    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function boostPosts()
    {
        return $this->hasMany(BoostPost::class, 'boost_plan_id');
    }
}
