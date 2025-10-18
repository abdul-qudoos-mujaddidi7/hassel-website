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

    // Translation methods are provided by the TranslatesFields trait

    // Helper Methods
}
