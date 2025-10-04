<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
  /**
   * Get translations for a specific language
   */
  public function getTranslations(string $language): JsonResponse
  {
    // Validate language
    $supportedLanguages = ['en', 'farsi', 'pashto'];
    if (!in_array($language, $supportedLanguages)) {
      return response()->json(['error' => 'Unsupported language'], 400);
    }

    try {
      // Get all translations for the language
      $translations = Translation::where('language', $language)
        ->get()
        ->mapWithKeys(function ($translation) {
          return [$translation->field_name => $translation->content];
        });

      // Merge with default translations if needed
      $defaultTranslations = $this->getDefaultTranslations($language);
      $mergedTranslations = array_merge($defaultTranslations, $translations->toArray());

      return response()->json($mergedTranslations);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to load translations'], 500);
    }
  }

  /**
   * Get default translations for a language
   */
  private function getDefaultTranslations(string $language): array
  {
    $defaults = [
      'en' => [
        'nav.home' => 'Home',
        'nav.work' => 'Our Work',
        'nav.training' => 'Training Programs',
        'nav.agri_tech' => 'Agri-Tech Tools',
        'nav.market_access' => 'Market Access',
        'nav.smart_farming' => 'Smart Farming',
        'nav.seed_supply' => 'Seed Supply',
        'nav.community' => 'Community Programs',
        'nav.environmental' => 'Environmental Projects',
        'nav.resources' => 'Resources',
        'nav.careers' => 'Careers',
        'nav.contact' => 'Contact',
        'common.loading' => 'Loading...',
        'common.error' => 'Error',
        'common.success' => 'Success',
        'careers.hero.title' => 'Join Our Team',
        'careers.hero.subtitle' => 'Build the future of agriculture with us',
        'loading.jobs' => 'Loading job openings...',
      ],
      'farsi' => [
        'nav.home' => 'خانه',
        'nav.work' => 'کار ما',
        'nav.training' => 'برنامه های آموزشی',
        'nav.agri_tech' => 'ابزارهای کشاورزی',
        'nav.market_access' => 'دسترسی به بازار',
        'nav.smart_farming' => 'کشاورزی هوشمند',
        'nav.seed_supply' => 'تأمین بذر',
        'nav.community' => 'برنامه های اجتماعی',
        'nav.environmental' => 'پروژه های محیطی',
        'nav.resources' => 'منابع',
        'nav.careers' => 'فرصت های شغلی',
        'nav.contact' => 'تماس',
        'common.loading' => 'در حال بارگذاری...',
        'common.error' => 'خطا',
        'common.success' => 'موفقیت',
        'careers.hero.title' => 'به تیم ما بپیوندید',
        'careers.hero.subtitle' => 'آینده کشاورزی را با ما بسازید',
        'loading.jobs' => 'در حال بارگذاری فرصت های شغلی...',
      ],
      'pashto' => [
        'nav.home' => 'کور',
        'nav.work' => 'زموږ کار',
        'nav.training' => 'د روزنې پروګرامونه',
        'nav.agri_tech' => 'د کرنې وسایل',
        'nav.market_access' => 'د بازار لاسرسی',
        'nav.smart_farming' => 'پاملرنې کرنه',
        'nav.seed_supply' => 'د تخم ورکړه',
        'nav.community' => 'د ټولنې پروګرامونه',
        'nav.environmental' => 'د چاپیریال پروژې',
        'nav.resources' => 'سرچینې',
        'nav.careers' => 'د دندو فرصتونه',
        'nav.contact' => 'اړیکه',
        'common.loading' => 'په بارولو کې...',
        'common.error' => 'تېروتنه',
        'common.success' => 'بریالیتوب',
        'careers.hero.title' => 'زموږ ټیم سره یوځای شئ',
        'careers.hero.subtitle' => 'د کرنې راتلونکی زموږ سره جوړ کړئ',
        'loading.jobs' => 'په دندو فرصتونو بارولو کې...',
      ]
    ];

    return $defaults[$language] ?? $defaults['en'];
  }

  /**
   * Set a translation for a specific key and language
   */
  public function setTranslation(Request $request): JsonResponse
  {
    $request->validate([
      'key' => 'required|string',
      'language' => 'required|string|in:en,farsi,pashto',
      'content' => 'required|string',
    ]);

    try {
      Translation::updateOrCreate(
        [
          'field_name' => $request->key,
          'language' => $request->language,
        ],
        [
          'content' => $request->content,
          'model_type' => 'static',
          'model_id' => 0,
        ]
      );

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to save translation'], 500);
    }
  }
}
