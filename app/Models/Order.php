<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'affiliate_id',
        'plan',
        'billing_cycle',
        'amount',
        'currency',
        'discount_amount',
        'coupon_code',
        'payment_gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'status',
        'affiliate_commission_amount',
        'is_commission_credited',
        'customer_email',
        'customer_name',
        'customer_phone',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'affiliate_commission_amount' => 'decimal:2',
            'is_commission_credited' => 'boolean',
            'metadata' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
