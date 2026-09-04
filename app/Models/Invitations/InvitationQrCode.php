<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationQrCode extends Model
{
    use HasFactory;

    protected $table = 'invitation_qr_codes';

    protected $fillable = [
        'invitation_id',
        'qr_type',
        'target_url',
        'code_string',
        'foreground_color',
        'background_color',
        'logo_url',
        'style_options',
        'download_count',
        'scan_count',
    ];

    protected $casts = [
        'style_options' => 'array',
        'download_count' => 'integer',
        'scan_count' => 'integer',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
