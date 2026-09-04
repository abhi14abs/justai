<?php

namespace App\Models\Invitations;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invitations';

    protected $fillable = [
        'uuid',
        'user_id',
        'template_id',
        'title',
        'slug',
        'cover_image',
        'event_date',
        'status',
        'password_protected',
        'music_url',
        'music_autoplay',
        'primary_color',
        'secondary_color',
        'accent_color',
        'font_family_heading',
        'font_family_body',
        'animation_style',
        'custom_domain',
        'custom_css',
        'seo_title',
        'seo_description',
        'og_image_url',
        'selected_features',
        'expires_at',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'expires_at' => 'datetime',
        'music_autoplay' => 'boolean',
        'selected_features' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($invitation) {
            if (empty($invitation->uuid)) {
                $invitation->uuid = (string) Str::uuid();
            }
            if (empty($invitation->slug)) {
                $invitation->slug = Str::slug($invitation->title) . '-' . Str::lower(Str::random(6));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function template()
    {
        return $this->belongsTo(InvitationTemplate::class, 'template_id');
    }

    public function sections()
    {
        return $this->hasMany(InvitationSection::class, 'invitation_id')->orderBy('sort_order');
    }

    public function enabledSections()
    {
        return $this->hasMany(InvitationSection::class, 'invitation_id')->where('is_enabled', true)->orderBy('sort_order');
    }

    public function events()
    {
        return $this->hasMany(InvitationEvent::class, 'invitation_id')->orderBy('sort_order');
    }

    public function assets()
    {
        return $this->hasMany(InvitationAsset::class, 'invitation_id')->orderBy('sort_order');
    }

    public function forms()
    {
        return $this->hasMany(InvitationForm::class, 'invitation_id');
    }

    public function rsvpForm()
    {
        return $this->hasOne(InvitationForm::class, 'invitation_id')->where('is_active', true)->latest();
    }

    public function formResponses()
    {
        return $this->hasMany(InvitationFormResponse::class, 'invitation_id');
    }

    public function guests()
    {
        return $this->hasMany(InvitationGuest::class, 'invitation_id');
    }

    public function qrCodes()
    {
        return $this->hasMany(InvitationQrCode::class, 'invitation_id');
    }

    public function analytics()
    {
        return $this->hasMany(InvitationAnalytics::class, 'invitation_id');
    }

    public function orders()
    {
        return $this->hasMany(InvitationOrder::class, 'invitation_id');
    }

    public function shareLinks()
    {
        return $this->hasMany(InvitationShareLink::class, 'invitation_id');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function hasFeature(string $featureCode): bool
    {
        $features = $this->selected_features ?? [];
        return in_array($featureCode, $features);
    }

    public function getPublicUrl(): string
    {
        if (!empty($this->custom_domain)) {
            return 'https://' . $this->custom_domain;
        }
        return url('/i/' . $this->slug);
    }

    public function getGuestUrl(string $guestCode): string
    {
        return $this->getPublicUrl() . '?g=' . urlencode($guestCode);
    }
}
