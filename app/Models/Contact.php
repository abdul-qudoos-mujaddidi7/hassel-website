<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'status',
  ];

  // Scopes
  public function scopeNew($query)
  {
    return $query->where('status', 'new');
  }

  public function scopeRead($query)
  {
    return $query->where('status', 'read');
  }

  public function scopeReplied($query)
  {
    return $query->where('status', 'replied');
  }

  public function scopeArchived($query)
  {
    return $query->where('status', 'archived');
  }

  // Accessors
  public function getIsNewAttribute(): bool
  {
    return $this->status === 'new';
  }

  public function getFormattedDateAttribute(): string
  {
    return $this->created_at->format('M d, Y H:i');
  }

  public function getMessageExcerptAttribute(): string
  {
    return substr($this->message, 0, 100) . (strlen($this->message) > 100 ? '...' : '');
  }

  // Helper Methods
  public function markAsRead()
  {
    $this->update(['status' => 'read']);
  }

  public function markAsReplied()
  {
    $this->update(['status' => 'replied']);
  }

  public function archive()
  {
    $this->update(['status' => 'archived']);
  }
}
