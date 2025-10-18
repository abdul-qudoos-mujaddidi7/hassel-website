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
        // Get the current language from the request or default to English
        $lang = request()->get('lang', 'en');
        $story = $this->getTranslation('story', $lang) ?? $this->story;
        return substr(strip_tags($story), 0, 200) . '...';
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
    
    // Get translation for a specific field and language
    public function getTranslation($field, $language = 'farsi')
    {
        $lang = $this->normalizeLanguage($language);
        if ($lang === 'en') {
            return $this->{$field} ?? null;
        }
        $translations = $lang === 'farsi' ? ($this->farsi_translations ?? []) : ($this->pashto_translations ?? []);
        return $translations[$field] ?? null;
    }
    
    // Set translation for a specific field and language
    public function setTranslation($field, $value, $language = 'farsi')
    {
        $language = $this->normalizeLanguage($language);
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
        $language = $this->normalizeLanguage($language);
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
