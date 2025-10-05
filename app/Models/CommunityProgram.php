<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityProgram extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
        'target_group',
        'partner_organizations',
    ];
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'target_group',
        'program_type',
        'location',
        'partner_organizations',
        'status',
        'featured_image',
        'cover_image',
        'thumbnail_image',
    ];

    protected $casts = [
        'partner_organizations' => 'array',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id')
            ->where('program_type', 'community_program');
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

    public function scopeForTargetGroup($query, $targetGroup)
    {
        return $query->where('target_group', $targetGroup);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('program_type', $type);
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getTargetGroupDisplayAttribute(): string
    {
        return ucwords($this->target_group);
    }

    public function getProgramTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->program_type));
    }

    public function getPartnerOrganizationsListAttribute(): array
    {
        return $this->partner_organizations ?: [];
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
