<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class SeedSupplyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'input_type',
        'target_crops',
        'quality_grade',
        'price_range',
        'availability',
        'shelf_life',
        'distribution_centers',
        'usage_instructions',
        'technical_specifications',
        'supplier',
        'contact_info',
        'cover_image',
        'thumbnail_image',
        'status',
    ];

    protected $casts = [
        'target_crops' => 'array',
        'distribution_centers' => 'array',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id')
            ->where('program_type', 'seed_supply');
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

    public function scopeByInputType($query, $type)
    {
        return $query->where('input_type', $type);
    }

    public function scopeByTargetCrops($query, $crops)
    {
        return $query->whereJsonContains('target_crops', $crops);
    }

    public function scopeInStock($query)
    {
        return $query->where('availability', 'In Stock');
    }

    public function scopeAvailable($query)
    {
        return $query->whereIn('availability', ['In Stock', 'Limited']);
    }

    // Accessors
    public function getIsInStockAttribute(): bool
    {
        return $this->availability === 'In Stock';
    }

    public function getIsAvailableAttribute(): bool
    {
        return in_array($this->availability, ['In Stock', 'Limited']);
    }

    public function getFormattedTargetCropsAttribute(): string
    {
        if (!$this->target_crops) return '';
        return implode(', ', array_map('ucfirst', $this->target_crops));
    }

    public function getFormattedDistributionCentersAttribute(): string
    {
        if (!$this->distribution_centers) return '';
        return implode(', ', $this->distribution_centers);
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

    public function canOrder(): bool
    {
        return $this->is_available && $this->status === 'published';
    }
}
