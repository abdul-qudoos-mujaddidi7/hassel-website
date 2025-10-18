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
        'farsi_translations',
        'pashto_translations',
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

    private function normalizeLanguage(string $language): string
    {
        $map = [
            'fa' => 'farsi',
            'farsi' => 'farsi',
            'ps' => 'pashto',
            'pashto' => 'pashto',
            'en' => 'en',
        ];
        $key = strtolower($language);
        return $map[$key] ?? 'en';
    }

    // Accessors for JSON fields
    public function getFarsiTranslationsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getPashtoTranslationsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    // Mutators for JSON fields
    public function setFarsiTranslationsAttribute($value)
    {
        $this->attributes['farsi_translations'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setPashtoTranslationsAttribute($value)
    {
        $this->attributes['pashto_translations'] = is_array($value) ? json_encode($value) : $value;
    }

    // Translation methods are provided by the TranslatesFields trait
}
