<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationCategory extends Model
{
    use HasFactory;

    protected $table = 'invitation_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'banner_url',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function subcategories()
    {
        return $this->hasMany(InvitationSubcategory::class, 'category_id')->orderBy('sort_order');
    }

    public function templates()
    {
        return $this->hasMany(InvitationTemplate::class, 'category_id');
    }

    public function activeTemplates()
    {
        return $this->hasMany(InvitationTemplate::class, 'category_id')->where('is_active', true);
    }
}
