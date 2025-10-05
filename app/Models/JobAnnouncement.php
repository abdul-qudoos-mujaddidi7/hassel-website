<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class JobAnnouncement extends Model
{
    use HasFactory, \App\Models\Concerns\TranslatesFields;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'location',
        'salary_range',
        'deadline',
        'status',
        'opened_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'opened_at' => 'datetime',
    ];

    /** @var array<int, string> */
    protected $translatable = [
        'title',
        'description',
        'requirements',
        'location',
    ];

    // Relationships
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model', 'model_type', 'model_id');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed')
            ->orWhere('deadline', '<', Carbon::today());
    }

    // Accessors
    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'open' && $this->deadline >= Carbon::today();
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->deadline < Carbon::today();
    }

    public function getDaysRemainingAttribute(): int
    {
        return $this->deadline > Carbon::today() ? Carbon::today()->diffInDays($this->deadline) : 0;
    }

    public function getRequirementsListAttribute(): array
    {
        return $this->requirements ? explode('\n', $this->requirements) : [];
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
