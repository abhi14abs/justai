<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationFeaturePrice extends Model
{
    use HasFactory;

    protected $table = 'invitation_feature_prices';

    protected $fillable = [
        'feature_id',
        'currency',
        'price',
        'tier_capacity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'tier_capacity' => 'integer',
    ];

    public function feature()
    {
        return $this->belongsTo(InvitationFeature::class, 'feature_id');
    }
}
