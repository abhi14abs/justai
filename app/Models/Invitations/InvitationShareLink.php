<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationShareLink extends Model
{
    use HasFactory;

    protected $table = 'invitation_share_links';

    protected $fillable = [
        'invitation_id',
        'channel',
        'custom_message',
        'clicks_count',
        'shares_count',
    ];

    protected $casts = [
        'clicks_count' => 'integer',
        'shares_count' => 'integer',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }
}
