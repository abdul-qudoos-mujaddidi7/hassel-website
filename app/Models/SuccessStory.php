<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class SuccessStory extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'client_name',
        'story',
    ];
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'story',
        'image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationships
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

    public function getStoryExcerptAttribute(): string
    {
        return substr(strip_tags($this->story), 0, 200) . '...';
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
