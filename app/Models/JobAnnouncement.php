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
    
    // Get translation for a specific field and language
    public function getTranslation($field, $language = 'farsi')
    {
        $translations = $language === 'farsi' ? $this->farsi_translations : $this->pashto_translations;
        return $translations[$field] ?? null;
    }
    
    // Set translation for a specific field and language
    public function setTranslation($field, $value, $language = 'farsi')
    {
        $translations = $language === 'farsi' ? $this->farsi_translations : $this->pashto_translations;
        $translations = $translations ?? [];
        $translations[$field] = $value;
        
        if ($language === 'farsi') {
            $this->farsi_translations = $translations;
        } else {
            $this->pashto_translations = $translations;
        }
    }
    
    // Get all translations for a language
    public function getTranslations($language = 'farsi')
    {
        return $language === 'farsi' ? $this->farsi_translations : $this->pashto_translations;
    }
    
    // Check if a field has translation
    public function hasTranslation($field, $language = 'farsi')
    {
        $translation = $this->getTranslation($field, $language);
        return !empty($translation) && trim($translation) !== '';
    }
    
    // Get translation coverage percentage for a language
    public function getTranslationCoverage($language = 'farsi')
    {
        $translations = $this->getTranslations($language);
        if (empty($translations)) return 0;
        
        $totalFields = count($this->translatable);
        $translatedFields = 0;
        
        foreach ($this->translatable as $field) {
            if ($this->hasTranslation($field, $language)) {
                $translatedFields++;
            }
        }
        
        return $totalFields > 0 ? round(($translatedFields / $totalFields) * 100) : 0;
    }
}
