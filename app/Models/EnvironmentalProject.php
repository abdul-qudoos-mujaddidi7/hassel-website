<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use App\Models\Translation;

class EnvironmentalProject extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
        'objectives',
        'methodology',
        'expected_outcomes',
        'funding_source',
    ];
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'thumbnail_image',
        'project_type',
        'location',
        'start_date',
        'end_date',
        'budget',
        'impact_level',
        'objectives',
        'methodology',
        'expected_outcomes',
        'partner_organizations',
        'impact_metrics',
        'funding_source',
        'status',
        'farsi_translations',
        'pashto_translations',
    ];

    protected $casts = [
        'impact_metrics' => 'array',
        'partner_organizations' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'farsi_translations' => 'array',
        'pashto_translations' => 'array',
    ];

    // Relationships
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model', 'model_type', 'model_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('project_type', $type);
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getImpactMetricsListAttribute(): array
    {
        return $this->impact_metrics ?: [];
    }

    public function getProjectTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->project_type));
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
    
    // Get translation for a specific field and language
    // This method checks both the translations table and JSON columns
    public function getTranslation($field, $language = 'farsi', $fallbackLanguage = 'en')
    {
        // Normalize language code (fa -> farsi, ps -> pashto, etc.)
        $normalizeLanguage = function($langCode) {
            $map = [
                'fa' => 'farsi',
                'farsi' => 'farsi',
                'ps' => 'pashto',
                'pashto' => 'pashto',
                'en' => 'en',
                'english' => 'en',
            ];
            $normalized = strtolower($langCode ?? 'en');
            return $map[$normalized] ?? 'en';
        };
        
        $normalizedLang = $normalizeLanguage($language);
        
        // First, try to get from translations table (via trait method if available)
        // Call parent trait method using call_user_func or directly query
        try {
            $translation = Translation::query()
                ->where('model_type', static::class)
                ->where('model_id', $this->getKey())
                ->where('field_name', $field)
                ->where('language', $normalizedLang)
                ->value('content');
            
            if ($translation !== null && $translation !== '') {
                return $translation;
            }
        } catch (\Exception $e) {
            // If translation table query fails, continue to JSON columns
        }
        
        // Fallback to JSON columns
        if ($normalizedLang === 'farsi') {
            $translations = $this->farsi_translations ?? [];
            return $translations[$field] ?? null;
        } elseif ($normalizedLang === 'pashto') {
            $translations = $this->pashto_translations ?? [];
            return $translations[$field] ?? null;
        }
        
        // For English, return base value
        return null;
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

    // Helper Methods
}
