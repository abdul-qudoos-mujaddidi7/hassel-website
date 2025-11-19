<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Gallery;
use App\Models\BeneficiariesStat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Get home page data with latest content and statistics
     */
    public function index(): JsonResponse
    {
        // Get latest stats
        $stats = BeneficiariesStat::currentYear()->get()->keyBy('stat_type');

        // Get latest news (3 most recent)
        $latestNews = News::published()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get featured galleries (3 most recent)
        $featuredGalleries = Gallery::published()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'hero' => [
                'title' => 'Empowering Afghanistan\'s Agricultural Future',
                'subtitle' => 'Leading agricultural innovation through sustainable farming, technology, and community empowerment.',
                'images' => [
                    'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1600&q=80',
                    'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=1600&q=80',
                    'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1600&q=80',
                ]
            ],
            'stats' => [
                ['label' => 'Beneficiaries', 'value' => $stats['beneficiaries']->value ?? 0, 'icon' => 'fa-solid fa-people-group'],
                ['label' => 'Projects', 'value' => $stats['projects']->value ?? 0, 'icon' => 'fa-solid fa-diagram-project'],
                ['label' => 'Staff', 'value' => $stats['staff']->value ?? 75, 'icon' => 'fa-solid fa-user-tie'],
                ['label' => 'Partners', 'value' => $stats['partners']->value ?? 0, 'icon' => 'fa-solid fa-handshake'],
            ],
            'latest_news' => $latestNews,
            'featured_galleries' => $featuredGalleries
        ]);
    }

    /**
     * Get about page data
     */
    public function about(): JsonResponse
    {
        return response()->json([
            'title' => 'About Mount Agro Institution',
            'content' => 'Mount Agro Institution (MAI) is Afghanistan\'s leading agricultural development organization, dedicated to transforming rural livelihoods through innovative farming solutions, technology integration, and sustainable practices.',
            'vision' => 'To be the leading catalyst for agricultural transformation and rural prosperity in Afghanistan.',
            'mission' => 'Empowering farmers and rural communities through innovative agricultural solutions, sustainable practices, and inclusive development programs.',
            'values' => [
                'Innovation in agricultural practices',
                'Sustainability and environmental stewardship',
                'Community empowerment and inclusion',
                'Excellence in service delivery',
                'Transparency and accountability'
            ],
            'business_pillars' => [
                [
                    'id' => 1,
                    'title' => 'Smart & Sustainable Farming',
                    'description' => 'Promoting climate-resilient agriculture and modern farming techniques',
                    'icon' => 'fa-solid fa-seedling'
                ],
                [
                    'id' => 2,
                    'title' => 'Agri-Education & Capacity Building',
                    'description' => 'Training farmers in advanced agricultural practices and skills',
                    'icon' => 'fa-solid fa-graduation-cap'
                ],
                [
                    'id' => 3,
                    'title' => 'Agri-Tech Solutions',
                    'description' => 'Innovative technology tools for modern agriculture',
                    'icon' => 'fa-solid fa-microchip'
                ],
                [
                    'id' => 4,
                    'title' => 'Seed & Input Supply Chain',
                    'description' => 'Quality seeds and agricultural inputs distribution',
                    'icon' => 'fa-solid fa-warehouse'
                ],
                [
                    'id' => 5,
                    'title' => 'Post-Harvest & Market Access',
                    'description' => 'Connecting farmers to markets and improving value chains',
                    'icon' => 'fa-solid fa-store'
                ],
                [
                    'id' => 6,
                    'title' => 'Community Empowerment & Inclusion',
                    'description' => 'Supporting women, youth, and vulnerable communities',
                    'icon' => 'fa-solid fa-people-group'
                ],
                [
                    'id' => 7,
                    'title' => 'Environmental Stewardship',
                    'description' => 'Promoting sustainable practices and environmental conservation',
                    'icon' => 'fa-solid fa-leaf'
                ]
            ]
        ]);
    }

    /**
     * Get comprehensive statistics
     */
    public function stats(): JsonResponse
    {
        $currentYearStats = BeneficiariesStat::currentYear()->get()->keyBy('stat_type');
        $allYearStats = BeneficiariesStat::latestYear()->get()->groupBy('year');

        return response()->json([
            'current_year' => $currentYearStats,
            'historical' => $allYearStats,
            'summary' => [
                'total_beneficiaries' => $currentYearStats['beneficiaries']->value ?? 15000,
                'active_projects' => $currentYearStats['projects']->value ?? 120,
                'team_members' => $currentYearStats['staff']->value ?? 75,
                'partner_organizations' => $currentYearStats['partners']->value ?? 25,
            ]
        ]);
    }
}
