<?php

namespace App\Models\Concerns;

use App\Models\Translation;
use Illuminate\Support\Str;

trait TranslatesFields
{
  /**
   * Get translated value for a field and language with fallback.
   */
  public function getTranslation(string $fieldName, string $language, ?string $fallbackLanguage = 'en')
  {
    // If field is not marked as translatable, skip DB call
    if (property_exists($this, 'translatable') && is_array($this->translatable)) {
      if (!in_array($fieldName, $this->translatable, true)) {
        return null;
      }
    }

    // Find translation
    $translation = Translation::query()
      ->where('model_type', static::class)
      ->where('model_id', $this->getKey())
      ->where('field_name', $fieldName)
      ->where('language', $language)
      ->value('value');

    if ($translation !== null && $translation !== '') {
      return $translation;
    }

    if ($fallbackLanguage && $fallbackLanguage !== $language) {
      $fallback = Translation::query()
        ->where('model_type', static::class)
        ->where('model_id', $this->getKey())
        ->where('field_name', $fieldName)
        ->where('language', $fallbackLanguage)
        ->value('value');

      if ($fallback !== null && $fallback !== '') {
        return $fallback;
      }
    }

    return null;
  }
}
