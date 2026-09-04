<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationGuestResponse extends Model
{
    use HasFactory;

    protected $table = 'invitation_guest_responses';

    protected $fillable = [
        'guest_id',
        'form_field_id',
        'response_value',
    ];

    public function guest()
    {
        return $this->belongsTo(InvitationGuest::class, 'guest_id');
    }

    public function formField()
    {
        return $this->belongsTo(InvitationFormField::class, 'form_field_id');
    }
}
