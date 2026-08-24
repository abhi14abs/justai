<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'ip_address',
        'referrer_url',
        'user_agent',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
