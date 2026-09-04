<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationFormField extends Model
{
    use HasFactory;

    protected $table = 'invitation_form_fields';

    protected $fillable = [
        'form_id',
        'event_id',
        'field_type',
        'label',
        'placeholder',
        'options',
        'is_required',
        'sort_order',
        'conditional_rules',
    ];

    protected $casts = [
        'options' => 'array',
        'conditional_rules' => 'array',
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(InvitationForm::class, 'form_id');
    }

    public function event()
    {
        return $this->belongsTo(InvitationEvent::class, 'event_id');
    }
}
