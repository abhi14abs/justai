<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationAnalytics extends Model
{
    use HasFactory;

    protected $table = 'invitation_analytics';

    public $timestamps = false;

    protected $fillable = [
        'invitation_id',
        'event_type',
        'guest_id',
        'ip_hash',
        'user_agent',
        'device_type',
        'referrer',
        'country_code',
        'city',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
