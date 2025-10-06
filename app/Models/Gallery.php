<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
    ];
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'status',
    ];

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }

    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getImageCountAttribute(): int
    {
        return $this->images()->count();
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        // Fallback to first image if no cover image
        $firstImage = $this->images()->first();
        return $firstImage ? asset('storage/' . $firstImage->image_path) : null;
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Helper Methods
}
