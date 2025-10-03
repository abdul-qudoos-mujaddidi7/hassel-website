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
    'job_title',
    'job_id',
    'location',
    'cv_file_path',
    'cover_letter',
  ];

  // Relationships
  public function job()
  {
    return $this->belongsTo(JobAnnouncement::class, 'job_id');
  }

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

  public function scopeJobApplications($query)
  {
    return $query->where('subject', 'job_application');
  }

  public function scopeBySubject($query, $subject)
  {
    return $query->where('subject', $subject);
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

  public function getIsJobApplicationAttribute(): bool
  {
    return $this->subject === 'job_application';
  }

  public function getSubjectDisplayAttribute(): string
  {
    return match ($this->subject) {
      'job_application' => 'Job Application',
      'technical_support' => 'Technical Support',
      'partnership' => 'Partnership',
      'project_discussion' => 'Project Discussion',
      'general_inquiry' => 'General Inquiry',
      'media_inquiry' => 'Media Inquiry',
      'other' => 'Other',
      default => ucfirst(str_replace('_', ' ', $this->subject))
    };
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
