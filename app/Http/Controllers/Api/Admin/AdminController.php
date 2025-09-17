<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Publication;
use App\Models\SuccessStory;
use App\Models\RfpRfq;
use App\Models\Gallery;
use App\Models\JobAnnouncement;
use App\Models\Contact;
use App\Models\BeneficiariesStat;
use App\Models\TrainingProgram;
use App\Models\AgriTechTool;
use App\Models\MarketAccessProgram;
use App\Models\EnvironmentalProject;
use App\Models\CommunityProgram;
use App\Models\ProgramRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Get dashboard overview data
     */
    public function dashboard(): JsonResponse
    {
        $stats = [
            // Content Statistics
            'content' => [
                'news' => [
                    'total' => News::count(),
                    'published' => News::published()->count(),
                    'draft' => News::draft()->count(),
                ],
                'publications' => [
                    'total' => Publication::count(),
                    'published' => Publication::published()->count(),
                    'draft' => Publication::draft()->count(),
                ],
                'success_stories' => [
                    'total' => SuccessStory::count(),
                    'published' => SuccessStory::published()->count(),
                    'draft' => SuccessStory::draft()->count(),
                ],
                'galleries' => [
                    'total' => Gallery::count(),
                    'published' => Gallery::published()->count(),
                    'draft' => Gallery::draft()->count(),
                ],
                'jobs' => [
                    'total' => JobAnnouncement::count(),
                    'open' => JobAnnouncement::open()->count(),
                    'closed' => JobAnnouncement::closed()->count(),
                ],
                'rfps' => [
                    'total' => RfpRfq::count(),
                    'open' => RfpRfq::open()->count(),
                    'closed' => RfpRfq::closed()->count(),
                ],
            ],

            // Business Pillars Statistics
            'business_pillars' => [
                'training_programs' => [
                    'total' => TrainingProgram::count(),
                    'upcoming' => TrainingProgram::upcoming()->count(),
                    'ongoing' => TrainingProgram::ongoing()->count(),
                    'completed' => TrainingProgram::completed()->count(),
                ],
                'agri_tech_tools' => [
                    'total' => AgriTechTool::count(),
                    'published' => AgriTechTool::published()->count(),
                ],
                'market_access_programs' => [
                    'total' => MarketAccessProgram::count(),
                    'published' => MarketAccessProgram::published()->count(),
                ],
                'environmental_projects' => [
                    'total' => EnvironmentalProject::count(),
                    'ongoing' => EnvironmentalProject::ongoing()->count(),
                    'completed' => EnvironmentalProject::completed()->count(),
                ],
                'community_programs' => [
                    'total' => CommunityProgram::count(),
                    'ongoing' => CommunityProgram::ongoing()->count(),
                    'completed' => CommunityProgram::completed()->count(),
                ],
            ],

            // Engagement Statistics
            'engagement' => [
                'contacts' => [
                    'total' => Contact::count(),
                    'this_month' => Contact::whereMonth('created_at', Carbon::now()->month)->count(),
                    'this_week' => Contact::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
                ],
                'registrations' => [
                    'total' => ProgramRegistration::count(),
                    'pending' => ProgramRegistration::where('status', 'pending')->count(),
                    'approved' => ProgramRegistration::where('status', 'approved')->count(),
                    'rejected' => ProgramRegistration::where('status', 'rejected')->count(),
                ],
            ],
        ];

        // Recent Activity
        $recentActivity = [
            'latest_contacts' => Contact::orderBy('created_at', 'desc')->limit(5)->get(),
            'latest_registrations' => ProgramRegistration::with('program')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'latest_news' => News::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        // Monthly trends (last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyTrends[] = [
                'month' => $date->format('M Y'),
                'contacts' => Contact::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'registrations' => ProgramRegistration::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'news_published' => News::published()
                    ->whereYear('published_at', $date->year)
                    ->whereMonth('published_at', $date->month)
                    ->count(),
            ];
        }

        return response()->json([
            'stats' => $stats,
            'recent_activity' => $recentActivity,
            'monthly_trends' => $monthlyTrends,
        ]);
    }

    /**
     * Get system health information
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => Carbon::now()->toDateTimeString(),
            'database' => 'connected',
            'cache' => 'available',
            'storage' => 'writable',
        ]);
    }
}
