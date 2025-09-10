<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'requirements',
        'benefits',
        'salary_min',
        'salary_max',
        'application_deadline',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'application_deadline' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
