<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class News extends Model
{
  use \App\Models\Concerns\TranslatesFields;

  /** @var array<int, string> */
  protected $translatable = [
    'title',
    'excerpt',
    'content',
  ];
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'excerpt',
    'content',
    'featured_image',
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

  public function scopeActive($query)
  {
    return $query->whereIn('status', ['published', 'draft']);
  }

  // Accessors
  public function getIsPublishedAttribute(): bool
  {
    return $this->status === 'published';
  }

  public function getExcerptLimitedAttribute(): string
  {
    return $this->excerpt ? substr($this->excerpt, 0, 150) . '...' : '';
  }

  public function getPublishedDateAttribute(): string
  {
    return $this->published_at ? $this->published_at->format('M d, Y') : '';
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
}
