<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'field_name',
        'language',
        'content',
    ];

    // Relationships
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeForModel($query, $modelType, $modelId)
    {
        return $query->where('model_type', $modelType)
            ->where('model_id', $modelId);
    }

    public function scopeForLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    public function scopeForField($query, $fieldName)
    {
        return $query->where('field_name', $fieldName);
    }

    // Helper Methods
    public static function getTranslation($modelType, $modelId, $fieldName, $language)
    {
        return static::where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->where('field_name', $fieldName)
            ->where('language', $language)
            ->value('content');
    }

    public static function setTranslation($modelType, $modelId, $fieldName, $language, $content)
    {
        return static::updateOrCreate(
            [
                'model_type' => $modelType,
                'model_id' => $modelId,
                'field_name' => $fieldName,
                'language' => $language,
            ],
            ['content' => $content]
        );
    }
}
