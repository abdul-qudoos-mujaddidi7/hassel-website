<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from request parameter, header, or default
        $language = $this->getLanguage($request);

        // Validate language
        $language = $this->validateLanguage($language);

        // Set application locale
        app()->setLocale($language);

        // Add language to request for easy access in controllers
        $request->merge(['app_language' => $language]);

        // Continue with request
        $response = $next($request);

        // Add language header to response
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $response->header('Content-Language', $language);
            $response->header('X-App-Language', $language);
        }

        return $response;
    }

    /**
     * Get language from various sources
     */
    private function getLanguage(Request $request): string
    {
        // Priority order:
        // 1. Query parameter (?lang=en)
        // 2. Header (Accept-Language)
        // 3. Session
        // 4. Default

        // 1. Query parameter
        if ($request->has('lang')) {
            return $request->get('lang');
        }

        // 2. Header
        $acceptLanguage = $request->header('Accept-Language');
        if ($acceptLanguage) {
            // Parse Accept-Language header (e.g., "en-US,en;q=0.9,fa;q=0.8")
            $languages = explode(',', $acceptLanguage);
            $primaryLanguage = trim(explode(';', $languages[0])[0]);

            // Map common language codes
            $languageMap = [
                'en' => 'en',
                'en-US' => 'en',
                'en-GB' => 'en',
                'fa' => 'farsi',
                'fa-IR' => 'farsi',
                'ps' => 'pashto',
                'ps-AF' => 'pashto',
            ];

            if (isset($languageMap[$primaryLanguage])) {
                return $languageMap[$primaryLanguage];
            }
        }

        // 3. Session (for future web interface)
        if (session()->has('language')) {
            return session('language');
        }

        // 4. Default
        return config('app.locale', 'en');
    }

    /**
     * Validate and normalize language code
     */
    private function validateLanguage(string $language): string
    {
        $supportedLanguages = ['en', 'pashto', 'farsi'];

        // Normalize language code
        $language = strtolower(trim($language));

        // Map alternative codes
        $languageAliases = [
            'english' => 'en',
            'dari' => 'farsi',
            'persian' => 'farsi',
            'fa' => 'farsi',
            'ps' => 'pashto',
            'pushto' => 'pashto',
        ];

        if (isset($languageAliases[$language])) {
            $language = $languageAliases[$language];
        }

        // Return valid language or default
        return in_array($language, $supportedLanguages) ? $language : 'en';
    }
}
