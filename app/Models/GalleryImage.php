<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    use \App\Models\Concerns\TranslatesFields;

    /** @var array<int, string> */
    protected $translatable = [
        'alt_text',
    ];
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'title',
        'image_path',
        'alt_text',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Relationships
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    public function getFileSizeAttribute(): ?string
    {
        if (!$this->image_path || !file_exists(storage_path('app/public/' . $this->image_path))) {
            return null;
        }

        $bytes = filesize(storage_path('app/public/' . $this->image_path));
        return $this->formatBytes($bytes);
    }

    // Helper Methods
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
