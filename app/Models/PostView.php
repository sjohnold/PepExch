<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;

   protected $guarded = ['id'];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(SellingPost::class, 'selling_post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
