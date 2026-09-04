<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'plan',
        'plan_expires_at',
        'credits_remaining',
        'referred_by_id',
        'affiliate_code',
        'api_token',
        'owner_id',
        'brand_workspaces',
        'team_members',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'plan_expires_at' => 'datetime',
            'password' => 'hashed',
            'brand_workspaces' => 'array',
            'team_members' => 'array',
        ];
    }

    /**
     * Boot model events.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->affiliate_code)) {
                $user->affiliate_code = Str::slug(explode('@', $user->email)[0] . '-' . Str::random(4));
            }
            if (empty($user->api_token) && in_array($user->plan, ['agency', 'pro', 'lifetime'])) {
                $user->api_token = 'pst_' . Str::random(32);
            }
        });
    }

    /**
     * Relationships
     */
    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function generations()
    {
        return $this->hasMany(Generation::class);
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invitations()
    {
        return $this->hasMany(\App\Models\Invitations\Invitation::class, 'user_id');
    }

    public function invitationOrders()
    {
        return $this->hasMany(\App\Models\Invitations\InvitationOrder::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgency(): bool
    {
        return $this->plan === 'agency' || $this->isAdmin();
    }

    public function isPro(): bool
    {
        return in_array($this->plan, ['pro', 'agency', 'lifetime']) || $this->isAdmin();
    }

    public function hasActivePaidPlan(): bool
    {
        return in_array($this->plan, ['starter', 'pro', 'agency', 'lifetime']);
    }

    public function generateApiToken(): string
    {
        $this->api_token = 'pst_' . Str::random(32);
        $this->save();
        return $this->api_token;
    }
}
