<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'author_name',
        'read_time',
        'meta_title',
        'meta_description',
        'is_active',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_active' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    /**
     * Scope for active blogs only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get accessible image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->featured_image)) {
            if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
                return $this->featured_image;
            }
            return asset($this->featured_image);
        }
        return asset('images/postryx-hero-banner.png');
    }

    /**
     * Calculate read time from content.
     */
    public static function calculateReadTime(string $content): string
    {
        $words = str_word_count(strip_tags($content));
        $minutes = max(1, (int) ceil($words / 200));
        return $minutes . ' min read';
    }
}
