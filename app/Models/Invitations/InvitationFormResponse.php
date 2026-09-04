<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationFormResponse extends Model
{
    use HasFactory;

    protected $table = 'invitation_form_responses';

    protected $fillable = [
        'form_id',
        'invitation_id',
        'guest_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'attending_status',
        'party_size',
        'dietary_preferences',
        'notes',
        'answers',
        'submitted_at',
        'ip_address',
    ];

    protected $casts = [
        'answers' => 'array',
        'party_size' => 'integer',
        'submitted_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(InvitationForm::class, 'form_id');
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    public function guest()
    {
        return $this->belongsTo(InvitationGuest::class, 'guest_id');
    }
}
