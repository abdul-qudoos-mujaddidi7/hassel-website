<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_type',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationships
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'model');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getFileExtensionAttribute(): ?string
    {
        return $this->file_path ? pathinfo($this->file_path, PATHINFO_EXTENSION) : null;
    }

    public function getFileSizeAttribute(): ?string
    {
        if (!$this->file_path || !file_exists(storage_path('app/public/' . $this->file_path))) {
            return null;
        }

        $bytes = filesize(storage_path('app/public/' . $this->file_path));
        return $this->formatBytes($bytes);
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

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
