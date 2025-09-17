<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class RfpRfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'deadline',
        'status',
        'published_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'published_at' => 'datetime',
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

    public function scopeOpen($query)
    {
        return $query->where('deadline', '>=', Carbon::today())
            ->whereIn('status', ['published']);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed')
            ->orWhere('deadline', '<', Carbon::today());
    }

    // Accessors
    public function getIsOpenAttribute(): bool
    {
        return $this->deadline >= Carbon::today() && $this->status === 'published';
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->deadline < Carbon::today();
    }

    public function getDaysRemainingAttribute(): int
    {
        return $this->deadline > Carbon::today() ? Carbon::today()->diffInDays($this->deadline) : 0;
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
