<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'cover_image',
        'meta_title', 'meta_description', 'meta_keywords',
        'og_image', 'og_type', 'canonical_url',
        'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Auto-generate slug from title
    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', $slug . '%')->count();
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }

    // Effective meta title (fallback to title)
    public function getEffectiveMetaTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title . ' — UMKM Sales';
    }

    // Effective meta description (fallback to excerpt)
    public function getEffectiveMetaDescriptionAttribute(): string
    {
        return $this->meta_description ?: Str::limit(strip_tags($this->excerpt ?? $this->content), 155);
    }

    // Effective OG image (fallback to cover)
    public function getEffectiveOgImageAttribute(): ?string
    {
        return $this->og_image ?: $this->cover_image;
    }

    // A03: XSS Prevention — sanitize stored content for safe rendering
    public function getSafeContentAttribute(): string
    {
        // Allow basic formatting tags, strip dangerous ones
        return strip_tags($this->content, [
            'p','br','strong','b','em','i','u','s',
            'h2','h3','h4','ul','ol','li','blockquote',
            'a','code','pre','hr','img',
        ]);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
