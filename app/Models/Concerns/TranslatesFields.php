<?php

namespace App\Models\Concerns;

use App\Models\Translation;
use Illuminate\Support\Str;

trait TranslatesFields
{
  private function normalizeLanguage(string $language): string
  {
    $map = [
      'fa' => 'farsi',
      'ps' => 'pashto',
      'en' => 'en',
      'farsi' => 'farsi',
      'pashto' => 'pashto',
    ];
    $key = strtolower($language);
    return $map[$key] ?? $key;
  }

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

    // Normalize language inputs to match DB enum values
    $normalized = $this->normalizeLanguage($language);
    $fallbackNorm = $fallbackLanguage ? $this->normalizeLanguage($fallbackLanguage) : null;

    // Find translation
    $translation = Translation::query()
      ->where('model_type', static::class)
      ->where('model_id', $this->getKey())
      ->where('field_name', $fieldName)
      ->where('language', $normalized)
      ->value('content');

    if ($translation !== null && $translation !== '') {
      return $translation;
    }

    if ($fallbackLanguage && $fallbackNorm !== $normalized) {
      $fallback = Translation::query()
        ->where('model_type', static::class)
        ->where('model_id', $this->getKey())
        ->where('field_name', $fieldName)
        ->where('language', $fallbackNorm)
        ->value('content');

      if ($fallback !== null && $fallback !== '') {
        return $fallback;
      }
    }

    return null;
  }
}
