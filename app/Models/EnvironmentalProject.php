<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EnvironmentalProject extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
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
        'impact_metrics',
        'location',
        'funding_source',
        'status',
        'farsi_translations',
        'pashto_translations',
    ];

    protected $casts = [
        'impact_metrics' => 'array',
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
            $this->attributes['slug'] = \Str::slug($value);
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

    // Helper Methods
}
