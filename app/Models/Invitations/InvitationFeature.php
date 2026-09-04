<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationFeature extends Model
{
    use HasFactory;

    protected $table = 'invitation_features';

    protected $fillable = [
        'code',
        'name',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function prices()
    {
        return $this->hasMany(InvitationFeaturePrice::class, 'feature_id');
    }

    public function getPrice(string $currency = 'INR', ?int $capacity = null): float
    {
        $query = $this->prices()->where('currency', $currency);
        if ($capacity !== null) {
            $price = $query->where('tier_capacity', $capacity)->first();
            if ($price) {
                return (float) $price->price;
            }
        }
        $defaultPrice = $this->prices()->where('currency', $currency)->first();
        return $defaultPrice ? (float) $defaultPrice->price : 0.00;
    }
}
