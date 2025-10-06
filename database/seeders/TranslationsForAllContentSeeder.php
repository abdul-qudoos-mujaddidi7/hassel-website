<?php

namespace Database\Seeders;

use App\Models\AgriTechTool;
use App\Models\CommunityProgram;
use App\Models\EnvironmentalProject;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\JobAnnouncement;
use App\Models\MarketAccessProgram;
use App\Models\News;
use App\Models\Publication;
use App\Models\SeedSupplyProgram;
use App\Models\SmartFarmingProgram;
use App\Models\SuccessStory;
use App\Models\TrainingProgram;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationsForAllContentSeeder extends Seeder
{
  public function run(): void
  {
    $models = [
      News::class,
      Publication::class,
      SuccessStory::class,
      TrainingProgram::class,
      AgriTechTool::class,
      SmartFarmingProgram::class,
      SeedSupplyProgram::class,
      MarketAccessProgram::class,
      EnvironmentalProject::class,
      CommunityProgram::class,
      JobAnnouncement::class,
      Gallery::class,
      GalleryImage::class,
    ];

    foreach ($models as $modelClass) {
      // Fetch in chunks to avoid memory spikes
      $modelClass::query()->chunk(100, function ($items) use ($modelClass) {
        foreach ($items as $item) {
          $fields = $this->getTranslatableFields($item);
          foreach ($fields as $field) {
            $base = (string)($item->{$field} ?? '');
            if ($base === '') {
              continue;
            }
            $this->upsertTranslation($item, $field, 'farsi', $this->fakeTranslate($base, 'fa'));
            $this->upsertTranslation($item, $field, 'pashto', $this->fakeTranslate($base, 'ps'));
          }
        }
      });
    }
  }

  private function getTranslatableFields($model): array
  {
    // Models declare $translatable via the TranslatesFields trait (protected property)
    if (property_exists($model, 'translatable')) {
      try {
        $ref = new \ReflectionProperty(get_class($model), 'translatable');
        $ref->setAccessible(true);
        $value = $ref->getValue($model);
        return is_array($value) ? $value : [];
      } catch (\Throwable $e) {
        return [];
      }
    }
    return [];
  }

  private function upsertTranslation($model, string $field, string $language, string $content): void
  {
    Translation::updateOrCreate([
      'model_type' => get_class($model),
      'model_id'   => $model->getKey(),
      'field_name' => $field,
      'language'   => $language,
    ], [
      'content'    => $content,
    ]);
  }

  private function fakeTranslate(string $text, string $lang): string
  {
    // Simple marker wrapper so you can visually confirm translations in UI
    // Replace later with real translations via admin UI
    if ($lang === 'fa') {
      return "[FA] " . $text;
    }
    if ($lang === 'ps') {
      return "[PS] " . $text;
    }
    return $text;
  }
}
