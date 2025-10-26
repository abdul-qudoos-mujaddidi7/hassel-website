<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AgriTechTool extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'name',
        'short_description',
        'description',
        'features',
        'specifications',
        'usage_instructions',
        'maintenance_requirements',
    ];
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'cover_image',
        'thumbnail_image',
        'tool_type',
        'features',
        'specifications',
        'usage_instructions',
        'maintenance_requirements',
        'technology_level',
        'availability',
        'price_range',
        'supplier',
        'contact_info',
        'download_link',
        'platform',
        'version',
        'status',
        'farsi_translations',
        'pashto_translations',
    ];

    protected $casts = [
        'features' => 'array',
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

    public function scopeByType($query, $type)
    {
        return $query->where('tool_type', $type);
    }

    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['published']);
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getIsDownloadableAttribute(): bool
    {
        return !empty($this->download_link);
    }

    public function getToolTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->tool_type));
    }

    public function getFeaturesListAttribute(): array
    {
        return $this->features ?: [];
    }

    public function getPlatformDisplayAttribute(): string
    {
        $platforms = [
            'android' => 'Android',
            'ios' => 'iOS',
            'web' => 'Web Application',
            'windows' => 'Windows',
            'macos' => 'macOS',
            'linux' => 'Linux',
        ];

        $platform = $this->platform ?? '';
        if (empty($platform)) {
            return '';
        }

        return $platforms[strtolower($platform)] ?? $platform;
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode($value);
        } else {
            $this->attributes['features'] = $value;
        }
    }

    // Helper Methods

    public function incrementDownloads()
    {
        // This could be implemented with a downloads counter if needed
        // For now, we'll just log the download event
    }
}
