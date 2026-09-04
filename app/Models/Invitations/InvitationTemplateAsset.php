<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationTemplateAsset extends Model
{
    use HasFactory;

    protected $table = 'invitation_template_assets';

    protected $fillable = [
        'template_id',
        'asset_type',
        'name',
        'file_url',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(InvitationTemplate::class, 'template_id');
    }
}
