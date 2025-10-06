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
        'description',
    ];
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'thumbnail_image',
        'tool_type',
        'features',
        'download_link',
        'platform',
        'version',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
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

        return $platforms[strtolower($this->platform)] ?? $this->platform;
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
        if (is_string($value)) {
            $value = array_filter(array_map('trim', explode('\n', $value)));
        }

        $this->attributes['features'] = json_encode($value);
    }

    // Helper Methods

    public function incrementDownloads()
    {
        // This could be implemented with a downloads counter if needed
        // For now, we'll just log the download event
    }
}
