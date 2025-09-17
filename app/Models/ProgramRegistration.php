<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProgramRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_type',
        'program_id',
        'user_name',
        'email',
        'phone',
        'location',
        'registration_date',
        'status',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    // Relationships
    public function program(): MorphTo
    {
        return $this->morphTo('program', 'program_type', 'program_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForProgramType($query, $programType)
    {
        return $query->where('program_type', $programType);
    }

    public function scopeForProgram($query, $programType, $programId)
    {
        return $query->where('program_type', $programType)
            ->where('program_id', $programId);
    }

    // Accessors
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getStatusDisplayAttribute(): string
    {
        return ucwords($this->status);
    }

    public function getProgramTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->program_type));
    }

    public function getFormattedRegistrationDateAttribute(): string
    {
        return $this->registration_date->format('M d, Y');
    }

    // Helper Methods
    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    // Get the actual program model instance
    public function getProgramInstance()
    {
        switch ($this->program_type) {
            case 'training_program':
                return TrainingProgram::find($this->program_id);
            case 'market_access_program':
                return MarketAccessProgram::find($this->program_id);
            case 'community_program':
                return CommunityProgram::find($this->program_id);
            default:
                return null;
        }
    }
}
