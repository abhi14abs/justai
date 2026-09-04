<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationAsset extends Model
{
    use HasFactory;

    protected $table = 'invitation_assets';

    protected $fillable = [
        'invitation_id',
        'asset_type',
        'file_path',
        'thumbnail_path',
        'caption',
        'sort_order',
        'file_size',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'file_size' => 'integer',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
