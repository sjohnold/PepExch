<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'selling_post_id',
        'sender_items',
        'receiver_items',
        'status',
        'sender_confirmed',
        'receiver_confirmed',
    ];

    protected $casts = [
        'sender_items' => 'array',
        'receiver_items' => 'array',
        'sender_confirmed' => 'boolean',
        'receiver_confirmed' => 'boolean',
    ];

    /**
     * Get the sender of the offer.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the offer.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the post that the offer is for.
     */
    public function sellingPost(): BelongsTo
    {
        return $this->belongsTo(SellingPost::class, 'selling_post_id');
    }
}
