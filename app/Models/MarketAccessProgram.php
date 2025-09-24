<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MarketAccessProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'thumbnail_image',
        'program_type',
        'target_crops',
        'location',
        'partner_organizations',
        'status',
    ];

    protected $casts = [
        'target_crops' => 'array',
        'partner_organizations' => 'array',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id')
            ->where('program_type', 'market_access_program');
    }

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

    public function scopeByCrop($query, $crop)
    {
        return $query->whereJsonContains('target_crops', $crop);
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getTargetCropsListAttribute(): array
    {
        return $this->target_crops ?: [];
    }

    public function getPartnerOrganizationsListAttribute(): array
    {
        return $this->partner_organizations ?: [];
    }

    public function getProgramTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->program_type));
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
    public function getTranslation($field, $language = 'en')
    {
        if ($language === 'en') {
            return $this->$field;
        }

        $translation = $this->translations()
            ->where('field_name', $field)
            ->where('language', $language)
            ->first();

        return $translation ? $translation->content : $this->$field;
    }
}
