<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TranslationSyncService
{
  /**
   * Sync translations for a model.
   * Payload format: [ lang => [ field_name => value|null ] ]
   */
  public static function sync(Model $model, array $translationsByLang): void
  {
    if (empty($translationsByLang)) {
      return;
    }

    $modelType = get_class($model);
    $modelId = $model->getKey();

    // Collectors for JSON columns update on models that support it
    $jsonCollect = [
      'farsi' => [],
      'pashto' => [],
    ];

    foreach ($translationsByLang as $language => $fields) {
      if (!is_array($fields)) {
        continue;
      }
      foreach ($fields as $fieldName => $value) {
        // Skip if model declares translatable and field not in list
        if (property_exists($model, 'translatable') && is_array($model->translatable)) {
          if (!in_array($fieldName, $model->translatable, true)) {
            continue;
          }
        }

        $query = Translation::query()
          ->where('model_type', $modelType)
          ->where('model_id', $modelId)
          ->where('field_name', $fieldName)
          ->where('language', $language);

        // If null/empty string -> delete to fallback to base value
        if ($value === null || $value === '') {
          $query->delete();
          continue;
        }

        // If value is already a JSON string (for arrays like features), keep it as is for storage
        // Otherwise, convert arrays to JSON strings for storage in the translations table
        $content = is_array($value) ? json_encode($value) : $value;
        
        // Parse JSON strings back to array for JSON column storage
        $arrayValue = $value;
        if (is_string($value) && (substr($value, 0, 1) === '[' || substr($value, 0, 1) === '{')) {
          try {
            $parsed = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
              $arrayValue = $parsed;
            }
          } catch (\Exception $e) {
            // Keep original value if parsing fails
          }
        }

        // Upsert
        $existing = $query->first();
        if ($existing) {
          $existing->content = $content;
          $existing->save();
        } else {
          Translation::create([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'field_name' => $fieldName,
            'language' => $language,
            'content' => $content,
          ]);
        }

        // Also collect for JSON columns when present on the model
        $langKey = strtolower($language);
        if (isset($jsonCollect[$langKey])) {
          // Store parsed array value for JSON columns (arrays are preserved as arrays)
          $jsonCollect[$langKey][$fieldName] = $arrayValue;
        }
      }
    }

    // If model has JSON translation columns, merge and persist them
    $didUpdateJson = false;
    $table = method_exists($model, 'getTable') ? $model->getTable() : null;
    if ($table && Schema::hasColumn($table, 'farsi_translations')) {
      $existing = (array) ($model->getAttribute('farsi_translations') ?? []);
      $merged = array_filter(array_merge($existing, $jsonCollect['farsi']), function ($v) {
        return !($v === null || $v === '');
      });
      $model->setAttribute('farsi_translations', $merged);
      $didUpdateJson = true;
    }
    if ($table && Schema::hasColumn($table, 'pashto_translations')) {
      $existing = (array) ($model->getAttribute('pashto_translations') ?? []);
      $merged = array_filter(array_merge($existing, $jsonCollect['pashto']), function ($v) {
        return !($v === null || $v === '');
      });
      $model->setAttribute('pashto_translations', $merged);
      $didUpdateJson = true;
    }
    if ($didUpdateJson) {
      // Avoid touching timestamps unless necessary
      $model->save();
    }
  }
}
