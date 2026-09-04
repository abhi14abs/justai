<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationPayment extends Model
{
    use HasFactory;

    protected $table = 'invitation_payments';

    protected $fillable = [
        'order_id',
        'transaction_ref',
        'gateway',
        'amount',
        'currency',
        'status',
        'raw_payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'raw_payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(InvitationOrder::class, 'order_id');
    }
}
