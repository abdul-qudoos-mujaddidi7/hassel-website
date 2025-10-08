<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TrainingProgram extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
        'program_type',
        'location',
        'instructor',
    ];
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'thumbnail_image',
        'program_type',
        'duration',
        'location',
        'instructor',
        'max_participants',
        'start_date',
        'end_date',
        'status',
        'farsi_translations',
        'pashto_translations',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'max_participants' => 'integer',
        'farsi_translations' => 'array',
        'pashto_translations' => 'array',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id')
            ->where('program_type', 'training_program');
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

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::today())
            ->where('status', 'published');
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', Carbon::today())
            ->where('end_date', '>=', Carbon::today())
            ->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('end_date', '<', Carbon::today())
            ->where('status', 'completed');
    }

    // Accessors
    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date > Carbon::today() && $this->status === 'published';
    }

    public function getIsOngoingAttribute(): bool
    {
        return $this->start_date <= Carbon::today() &&
            $this->end_date >= Carbon::today() &&
            $this->status === 'ongoing';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->end_date < Carbon::today() || $this->status === 'completed';
    }

    public function getAvailableSpotsAttribute(): int
    {
        if (!$this->max_participants) {
            return 999; // Unlimited
        }

        $registeredCount = $this->registrations()->where('status', 'approved')->count();
        return max(0, $this->max_participants - $registeredCount);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->max_participants && $this->available_spots <= 0;
    }

    public function getDurationInDaysAttribute(): ?int
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->end_date) + 1;
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

    public function canRegister(): bool
    {
        return $this->is_upcoming && !$this->is_full && $this->status === 'published';
    }
}
