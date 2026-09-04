<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationSection extends Model
{
    use HasFactory;

    protected $table = 'invitation_sections';

    protected $fillable = [
        'invitation_id',
        'section_type',
        'title',
        'subtitle',
        'content',
        'settings',
        'sort_order',
        'is_enabled',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'sort_order' => 'integer',
        'is_enabled' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
