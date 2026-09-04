<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InvitationGuest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invitation_guests';

    protected $fillable = [
        'invitation_id',
        'guest_code',
        'name',
        'email',
        'phone',
        'group_name',
        'allocated_seats',
        'attending_status',
        'is_vip',
        'check_in_status',
        'checked_in_at',
        'qr_code_path',
        'custom_notes',
    ];

    protected $casts = [
        'allocated_seats' => 'integer',
        'is_vip' => 'boolean',
        'check_in_status' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($guest) {
            if (empty($guest->guest_code)) {
                $guest->guest_code = 'GST-' . strtoupper(Str::random(6));
            }
        });
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    public function guestEvents()
    {
        return $this->hasMany(InvitationGuestEvent::class, 'guest_id');
    }

    public function guestResponses()
    {
        return $this->hasMany(InvitationGuestResponse::class, 'guest_id');
    }

    public function formResponses()
    {
        return $this->hasMany(InvitationFormResponse::class, 'guest_id');
    }

    public function getPersonalizedUrl(): string
    {
        return $this->invitation ? $this->invitation->getGuestUrl($this->guest_code) : '';
    }
}
