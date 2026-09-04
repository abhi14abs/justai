<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationTemplateSection extends Model
{
    use HasFactory;

    protected $table = 'invitation_template_sections';

    protected $fillable = [
        'template_id',
        'section_type',
        'default_title',
        'default_subtitle',
        'default_content',
        'default_settings',
        'sort_order',
        'is_required',
    ];

    protected $casts = [
        'default_content' => 'array',
        'default_settings' => 'array',
        'sort_order' => 'integer',
        'is_required' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(InvitationTemplate::class, 'template_id');
    }
}
