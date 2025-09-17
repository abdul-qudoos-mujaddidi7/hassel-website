<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Publication;
use App\Models\Contact;
use App\Models\ProgramRegistration;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\StatsResource;

class AdminStatsController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $stats = [
            'content' => [
                'total_news' => News::count(),
                'published_news' => News::published()->count(),
                'total_publications' => Publication::count(),
                'published_publications' => Publication::published()->count(),
            ],
            'engagement' => [
                'total_contacts' => Contact::count(),
                'unread_contacts' => Contact::where('status', 'unread')->count(),
                'total_registrations' => ProgramRegistration::count(),
                'pending_registrations' => ProgramRegistration::where('status', 'pending')->count(),
            ],
            'translations' => [
                'total_translations' => Translation::count(),
                'pashto_translations' => Translation::where('language', 'pashto')->count(),
                'farsi_translations' => Translation::where('language', 'farsi')->count(),
            ],
        ];

        return response()->json(['stats' => $stats]);
    }

    public function contentGrowth(): JsonResponse
    {
        $growth = [
            'news_last_30_days' => News::where('created_at', '>=', now()->subDays(30))->count(),
            'publications_last_30_days' => Publication::where('created_at', '>=', now()->subDays(30))->count(),
            'contacts_last_7_days' => Contact::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return response()->json(['growth' => $growth]);
    }
}
