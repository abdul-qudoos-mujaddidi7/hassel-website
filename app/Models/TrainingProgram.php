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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'max_participants' => 'integer',
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

    public function canRegister(): bool
    {
        return $this->is_upcoming && !$this->is_full && $this->status === 'published';
    }
}
