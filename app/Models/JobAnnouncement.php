<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class JobAnnouncement extends Model
{
    use HasFactory, \App\Models\Concerns\TranslatesFields;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'location',
        'salary_range',
        'deadline',
        'status',
        'opened_at',
        'farsi_translations',
        'pashto_translations',
    ];

    protected $casts = [
        'deadline' => 'date',
        'opened_at' => 'datetime',
        'farsi_translations' => 'array',
        'pashto_translations' => 'array',
    ];

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
        'requirements',
        'location',
    ];

    // Relationships
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model', 'model_type', 'model_id');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed')
            ->orWhere('deadline', '<', Carbon::today());
    }

    // Accessors
    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'open' && $this->deadline >= Carbon::today();
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->deadline < Carbon::today();
    }

    public function getDaysRemainingAttribute(): int
    {
        return $this->deadline > Carbon::today() ? Carbon::today()->diffInDays($this->deadline) : 0;
    }

    public function getRequirementsListAttribute(): array
    {
        return $this->requirements ? explode('\n', $this->requirements) : [];
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    // Helper Methods
    
    /**
     * Override getTranslation to use JSON columns instead of translations table
     */
    public function getTranslation(string $fieldName, string $language, ?string $fallbackLanguage = 'en')
    {
        // If field is not marked as translatable, return null
        if (!in_array($fieldName, $this->translatable, true)) {
            return null;
        }

        // Normalize language
        $normalized = $this->normalizeLanguage($language);
        
        // Get translation from JSON column
        $translations = null;
        if ($normalized === 'farsi' && $this->farsi_translations) {
            $translations = $this->farsi_translations;
        } elseif ($normalized === 'pashto' && $this->pashto_translations) {
            $translations = $this->pashto_translations;
        }

        if ($translations && isset($translations[$fieldName]) && $translations[$fieldName] !== '') {
            return $translations[$fieldName];
        }

        // Fallback to original value
        return $this->getAttribute($fieldName);
    }
    
    /**
     * Normalize language code
     */
    private function normalizeLanguage(string $language): string
    {
        $map = [
            'fa' => 'farsi',
            'ps' => 'pashto',
            'en' => 'en',
            'farsi' => 'farsi',
            'pashto' => 'pashto',
        ];
        $key = strtolower($language);
        return $map[$key] ?? $key;
    }
}
