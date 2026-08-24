<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'affiliate_code',
        'payout_method',
        'payout_details',
        'commission_rate',
        'total_clicks',
        'total_referrals',
        'total_earnings',
        'pending_payout',
        'paid_payout',
    ];

    protected function casts(): array
    {
        return [
            'commission_rate' => 'decimal:2',
            'total_earnings' => 'decimal:2',
            'pending_payout' => 'decimal:2',
            'paid_payout' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clicks()
    {
        return $this->hasMany(ReferralClick::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payouts()
    {
        return $this->hasMany(AffiliatePayout::class);
    }
}
