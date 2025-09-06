<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'items',
        'total_amount',
        'currency',
        'status',
        'payment_transaction_id',
        'fulfilled_at',
        'failed_at',
        'failed_reason',
    ];

    protected $casts = [
        'items' => 'array',
        'total_amount' => 'decimal:2',
        'fulfilled_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
