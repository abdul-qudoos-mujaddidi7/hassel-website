## Dynamic Translations API Guide

This documents how to send and receive translations for dynamic content (News, Publications, Success Stories, Jobs, Programs, Galleries, etc.). Works with 3 languages: `en` (base), `fa` (Farsi), `ps` (Pashto).

### Query parameter: lang

-   Append `?lang=en|fa|ps` to any public/admin API request to receive translated values with fallback to English when missing.
-   An interceptor already appends the current UI language automatically.

### Response option: include_translations

-   Add `?include_translations=1` to `show`/`index` endpoints to include raw translation rows for admin edit forms.
-   Example partial response shape:

```
{
  "id": 1,
  "title": "Base English title or translated title for ?lang",
  "description": "...",
  "translations": [
    {
      "model_type": "App\\Models\\News",
      "model_id": 1,
      "field_name": "title",
      "language": "fa",
      "content": "فارسی عنوان"
    },
    {
      "model_type": "App\\Models\\News",
      "model_id": 1,
      "field_name": "title",
      "language": "ps",
      "content": "پښتو سرلیک"
    }
  ]
}
```

### Create/Update payload shape

Submit one unified payload that includes base fields (English stored on the model) and optional translations per language.

```
{
  "title": "English title",
  "description": "English description",
  // ...other base fields...

  "translations": {
    "fa": {
      "title": "فارسی عنوان",
      "description": "فارسی توضیحات"
    },
    "ps": {
      "title": "د پښتو سرلیک",
      "description": "د پښتو تشریح"
    }
  }
}
```

Notes:

-   Omit a language or field to leave it unchanged.
-   Send an empty string for a field to delete that translation for that language.

### Server behavior

-   Controllers persist base fields normally, then call `TranslationSyncService::sync($model, $request->input('translations', []))` to upsert/delete translations.
-   API Resources automatically resolve fields via `getTranslation(field, ?lang)` with fallback to English.

### Minimal example endpoints

-   POST `/api/admin/news` → create News with translations
-   PUT `/api/admin/news/{id}` → update News and translations
-   GET `/api/news?lang=fa` → list news in Farsi (fallback to English when missing)
-   GET `/api/admin/news/{id}?include_translations=1` → fetch for edit form with raw translations
