<?php

namespace App\Models\Invitations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationSubcategory extends Model
{
    use HasFactory;

    protected $table = 'invitation_subcategories';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(InvitationCategory::class, 'category_id');
    }

    public function templates()
    {
        return $this->hasMany(InvitationTemplate::class, 'subcategory_id');
    }
}
