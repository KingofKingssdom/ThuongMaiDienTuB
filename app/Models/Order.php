<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'user_id',
        'order_status',
        'sub_total',
        'shipping_fee',
        'discount_amount',
        'grand_total',
        'payment_method',
        'payment_status',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'note',
    ];

    protected $casts = [
        'sub_total'       => 'double',
        'shipping_fee'    => 'double',
        'discount_amount' => 'double',
        'grand_total'     => 'double',
    ];

    // Quan hệ thuộc về User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ một - nhiều với OrderItem
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}