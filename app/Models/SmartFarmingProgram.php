<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SmartFarmingProgram extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'name',
        'short_description',
        'description',
        'implementation_guide',
        'sustainability_impact',
        'farming_type',
        'target_crops',
        'location',
    ];
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'farming_type',
        'target_crops',
        'sustainability_level',
        'implementation_guide',
        'sustainability_impact',
        'duration',
        'location',
        'application_deadline',
        'cover_image',
        'thumbnail_image',
        'status',
    ];

    protected $casts = [
        'target_crops' => 'array',
        'application_deadline' => 'date',
        'sustainability_level' => 'integer',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id')
            ->where('program_type', 'smart_farming');
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

    public function scopeByFarmingType($query, $type)
    {
        return $query->where('farming_type', $type);
    }

    public function scopeByTargetCrops($query, $crops)
    {
        return $query->whereJsonContains('target_crops', $crops);
    }

    public function scopeAvailable($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('application_deadline')
                ->orWhere('application_deadline', '>=', Carbon::today());
        });
    }

    // Accessors
    public function getIsAvailableAttribute(): bool
    {
        return !$this->application_deadline || $this->application_deadline >= Carbon::today();
    }

    public function getFormattedTargetCropsAttribute(): string
    {
        if (!$this->target_crops) return '';
        return implode(', ', array_map('ucfirst', $this->target_crops));
    }

    public function getSustainabilityLevelDisplayAttribute(): string
    {
        return $this->sustainability_level ? $this->sustainability_level . '%' : 'N/A';
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Helper Methods

    public function canApply(): bool
    {
        return $this->is_available && $this->status === 'published';
    }
}
