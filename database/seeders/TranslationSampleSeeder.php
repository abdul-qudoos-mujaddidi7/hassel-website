<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Publication;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSampleSeeder extends Seeder
{
  public function run(): void
  {
    // Pick first available News and Publication
    $news = News::query()->select('id', 'title', 'excerpt', 'content')->first();
    $pub  = Publication::query()->select('id', 'title', 'description')->first();

    if ($news) {
      $this->seedTranslationsFor($news, [
        'title' => [
          'farsi' => 'نمونه خبرونه سرلیک (فارسی)',
          'pashto' => 'د خبرونو بیلګه سرلیک (پښتو)'
        ],
        'excerpt' => [
          'farsi' => 'خلاصه خبر (فارسی)',
          'pashto' => 'د خبرونو لنډیز (پښتو)'
        ],
        'content' => [
          'farsi' => 'محتوای خبر به زبان فارسی برای تست سیستم ترجمه.',
          'pashto' => 'د پښتو ژبې لپاره د خبرونو منځپانګه د ازموینې په موخه.'
        ],
      ]);
    }

    if ($pub) {
      $this->seedTranslationsFor($pub, [
        'title' => [
          'farsi' => 'عنوان نشرات (فارسی)',
          'pashto' => 'د خپرونو سرلیک (پښتو)'
        ],
        'description' => [
          'farsi' => 'توضیحات نشرات به زبان فارسی برای تست.',
          'pashto' => 'د خپرونو تشریح په پښتو ژبه د ازموینې لپاره.'
        ],
      ]);
    }
  }

  private function seedTranslationsFor($model, array $fieldMap): void
  {
    foreach ($fieldMap as $field => $langs) {
      foreach ($langs as $lang => $content) {
        Translation::updateOrCreate([
          'model_type' => get_class($model),
          'model_id'   => $model->getKey(),
          'field_name' => $field,
          'language'   => $lang,
        ], [
          'content'    => $content,
        ]);
      }
    }
  }
}
