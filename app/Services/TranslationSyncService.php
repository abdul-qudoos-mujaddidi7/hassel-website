<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;

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

        // Upsert
        $existing = $query->first();
        if ($existing) {
          $existing->value = $value;
          $existing->save();
        } else {
          Translation::create([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'field_name' => $fieldName,
            'language' => $language,
            'value' => $value,
          ]);
        }
      }
    }
  }
}
