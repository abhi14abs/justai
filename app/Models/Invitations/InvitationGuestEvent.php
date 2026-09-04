<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationGuestEvent extends Model
{
    use HasFactory;

    protected $table = 'invitation_guest_events';

    protected $fillable = [
        'guest_id',
        'event_id',
        'invitation_id',
        'is_invited',
        'attending_status',
    ];

    protected $casts = [
        'is_invited' => 'boolean',
    ];

    public function guest()
    {
        return $this->belongsTo(InvitationGuest::class, 'guest_id');
    }

    public function event()
    {
        return $this->belongsTo(InvitationEvent::class, 'event_id');
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
