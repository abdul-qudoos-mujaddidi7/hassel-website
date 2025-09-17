<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BeneficiariesStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_type',
        'value',
        'description',
        'year',
    ];

    protected $casts = [
        'value' => 'integer',
        'year' => 'integer',
    ];

    // Relationships
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model', 'model_type', 'model_id');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('stat_type', $type);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeCurrentYear($query)
    {
        return $query->where('year', date('Y'));
    }

    public function scopeLatestYear($query)
    {
        return $query->orderBy('year', 'desc');
    }

    // Accessors
    public function getFormattedValueAttribute(): string
    {
        return number_format($this->value);
    }

    public function getStatTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->stat_type));
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

    // Static Methods
    public static function getStatsByType($type, $year = null)
    {
        $query = static::byType($type);

        if ($year) {
            $query->byYear($year);
        } else {
            $query->currentYear();
        }

        return $query->first();
    }

    public static function getAllStatsForYear($year = null)
    {
        $year = $year ?: date('Y');

        return static::byYear($year)->get()->keyBy('stat_type');
    }
}
