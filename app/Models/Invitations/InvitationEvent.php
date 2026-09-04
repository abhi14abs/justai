<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationEvent extends Model
{
    use HasFactory;

    protected $table = 'invitation_events';

    protected $fillable = [
        'invitation_id',
        'title',
        'event_date',
        'start_time',
        'end_time',
        'venue_name',
        'venue_address',
        'map_embed_url',
        'map_latitude',
        'map_longitude',
        'dress_code',
        'icon',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'map_latitude' => 'decimal:8',
        'map_longitude' => 'decimal:8',
        'sort_order' => 'integer',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    public function guestEvents()
    {
        return $this->hasMany(InvitationGuestEvent::class, 'event_id');
    }
}
