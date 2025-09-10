<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'excerpt',
    'content',
    'featured_image',
    'is_published',
    'published_at',
  ];

  protected $casts = [
    'is_published' => 'boolean',
    'published_at' => 'datetime',
  ];

  public function scopePublished($query)
  {
    return $query->where('is_published', true);
  }
}
