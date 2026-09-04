<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invitation_templates';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'thumbnail_url',
        'preview_url',
        'theme_config',
        'is_premium',
        'base_price_inr',
        'base_price_usd',
        'is_active',
        'is_featured',
        'view_count',
        'use_count',
        'tags',
    ];

    protected $casts = [
        'theme_config' => 'array',
        'tags' => 'array',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'base_price_inr' => 'decimal:2',
        'base_price_usd' => 'decimal:2',
        'view_count' => 'integer',
        'use_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(InvitationCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(InvitationSubcategory::class, 'subcategory_id');
    }

    public function sections()
    {
        return $this->hasMany(InvitationTemplateSection::class, 'template_id')->orderBy('sort_order');
    }

    public function assets()
    {
        return $this->hasMany(InvitationTemplateAsset::class, 'template_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'template_id');
    }

    public function getPrice(string $currency = 'INR'): float
    {
        return $currency === 'USD' ? (float) $this->base_price_usd : (float) $this->base_price_inr;
    }
}
