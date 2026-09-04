<?php

namespace App\Models\Invitations;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationOrder extends Model
{
    use HasFactory;

    protected $table = 'invitation_orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'invitation_id',
        'template_id',
        'amount',
        'currency',
        'discount_amount',
        'coupon_code',
        'tax_amount',
        'final_amount',
        'payment_gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'status',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    public function template()
    {
        return $this->belongsTo(InvitationTemplate::class, 'template_id');
    }

    public function items()
    {
        return $this->hasMany(InvitationOrderItem::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(InvitationPayment::class, 'order_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
