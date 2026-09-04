<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationOrderItem extends Model
{
    use HasFactory;

    protected $table = 'invitation_order_items';

    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'item_name',
        'unit_price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(InvitationOrder::class, 'order_id');
    }
}
