<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationForm extends Model
{
    use HasFactory;

    protected $table = 'invitation_forms';

    protected $fillable = [
        'invitation_id',
        'title',
        'description',
        'deadline',
        'max_party_size',
        'allow_guest_plus_one',
        'is_active',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'max_party_size' => 'integer',
        'allow_guest_plus_one' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    public function fields()
    {
        return $this->hasMany(InvitationFormField::class, 'form_id')->orderBy('sort_order');
    }

    public function responses()
    {
        return $this->hasMany(InvitationFormResponse::class, 'form_id');
    }
}
