<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\TrainingProgram;
use App\Models\Contact;
use App\Models\ProgramRegistration;
use App\Models\User;
use App\Models\Publication;
use App\Models\SuccessStory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        try {
            $stats = [
                'success' => true,
                'data' => [
                    // News stats
                    'news' => [
                        'total' => News::count(),
                        'published' => News::where('status', 'published')->count(),
                        'draft' => News::where('status', 'draft')->count(),
                    ],
                    
                    // Publications stats
                    'publications' => [
                        'total' => Publication::count(),
                        'published' => Publication::where('status', 'published')->count(),
                        'draft' => Publication::where('status', 'draft')->count(),
                    ],
                    
                    // Success Stories stats
                    'success_stories' => [
                        'total' => SuccessStory::count(),
                        'published' => SuccessStory::where('status', 'published')->count(),
                    ],
                    
                    // Training Programs stats
                    'training_programs' => [
                        'total' => TrainingProgram::count(),
                        'active' => TrainingProgram::where('status', 'published')->count(),
                    ],
                    
                    // Contacts stats
                    'contacts' => [
                        'total' => Contact::count(),
                        'new' => Contact::where('status', 'new')->count(),
                        'read' => Contact::where('status', 'read')->count(),
                        'replied' => Contact::where('status', 'replied')->count(),
                    ],
                    
                    // Content breakdown by type/category
                    'news_breakdown' => $this->getNewsBreakdown(),
                    'publications_breakdown' => $this->getPublicationsBreakdown(),
                    'training_breakdown' => $this->getTrainingBreakdown(),
                    
                    // Time-based content counts
                    'daily_content' => $this->getDailyContent(),
                    'monthly_content' => $this->getMonthlyContent(),
                    'yearly_content' => $this->getYearlyContent(),
                    
                    // Recent contacts
                    'recent_contacts' => $this->getRecentContacts(),
                ]
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch dashboard statistics',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    private function getNewsBreakdown()
    {
        // Group news by status since category column might not exist
        try {
            return DB::table('news')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => ucfirst($item->status ?: 'Uncategorized'),
                        'count' => $item->count,
                    ];
                })->toArray();
        } catch (\Exception $e) {
            return [
                ['category' => 'Published', 'count' => News::where('status', 'published')->count()],
                ['category' => 'Draft', 'count' => News::where('status', 'draft')->count()],
            ];
        }
    }
    
    private function getPublicationsBreakdown()
    {
        // Group publications by file type or status if file_type is null
        try {
            $breakdown = DB::table('publications')
                ->select('file_type', DB::raw('count(*) as count'))
                ->whereNotNull('file_type')
                ->groupBy('file_type')
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => strtoupper($item->file_type ?: 'Unknown'),
                        'count' => $item->count,
                    ];
                })->toArray();
            
            // If no file types, fall back to status
            if (empty($breakdown)) {
                return [
                    ['category' => 'Published', 'count' => Publication::where('status', 'published')->count()],
                    ['category' => 'Draft', 'count' => Publication::where('status', 'draft')->count()],
                ];
            }
            
            return $breakdown;
        } catch (\Exception $e) {
            return [
                ['category' => 'Published', 'count' => Publication::where('status', 'published')->count()],
                ['category' => 'Draft', 'count' => Publication::where('status', 'draft')->count()],
            ];
        }
    }
    
    private function getTrainingBreakdown()
    {
        // Group training programs by program_type or status if program_type doesn't exist
        try {
            $breakdown = DB::table('training_programs')
                ->select('program_type', DB::raw('count(*) as count'))
                ->whereNotNull('program_type')
                ->groupBy('program_type')
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => $item->program_type ?: 'General',
                        'count' => $item->count,
                    ];
                })->toArray();
            
            // If no program types, fall back to status
            if (empty($breakdown)) {
                return [
                    ['category' => 'Published', 'count' => TrainingProgram::where('status', 'published')->count()],
                    ['category' => 'Draft', 'count' => TrainingProgram::where('status', 'draft')->count()],
                ];
            }
            
            return $breakdown;
        } catch (\Exception $e) {
            return [
                ['category' => 'Published', 'count' => TrainingProgram::where('status', 'published')->count()],
                ['category' => 'Draft', 'count' => TrainingProgram::where('status', 'draft')->count()],
            ];
        }
    }
    
    private function getDailyContent()
    {
        $today = now()->startOfDay();
        
        return [
            ['category' => 'News', 'count' => News::where('created_at', '>=', $today)->count()],
            ['category' => 'Publications', 'count' => Publication::where('created_at', '>=', $today)->count()],
            ['category' => 'Success Stories', 'count' => SuccessStory::where('created_at', '>=', $today)->count()],
            ['category' => 'Training Programs', 'count' => TrainingProgram::where('created_at', '>=', $today)->count()],
            ['category' => 'Contacts', 'count' => Contact::where('created_at', '>=', $today)->count()],
        ];
    }
    
    private function getMonthlyContent()
    {
        $monthStart = now()->startOfMonth();
        
        return [
            ['category' => 'News', 'count' => News::where('created_at', '>=', $monthStart)->count()],
            ['category' => 'Publications', 'count' => Publication::where('created_at', '>=', $monthStart)->count()],
            ['category' => 'Success Stories', 'count' => SuccessStory::where('created_at', '>=', $monthStart)->count()],
            ['category' => 'Training Programs', 'count' => TrainingProgram::where('created_at', '>=', $monthStart)->count()],
            ['category' => 'Contacts', 'count' => Contact::where('created_at', '>=', $monthStart)->count()],
        ];
    }
    
    private function getYearlyContent()
    {
        $yearStart = now()->startOfYear();
        
        return [
            ['category' => 'News', 'count' => News::where('created_at', '>=', $yearStart)->count()],
            ['category' => 'Publications', 'count' => Publication::where('created_at', '>=', $yearStart)->count()],
            ['category' => 'Success Stories', 'count' => SuccessStory::where('created_at', '>=', $yearStart)->count()],
            ['category' => 'Training Programs', 'count' => TrainingProgram::where('created_at', '>=', $yearStart)->count()],
            ['category' => 'Contacts', 'count' => Contact::where('created_at', '>=', $yearStart)->count()],
        ];
    }
    
    private function getRecentContacts()
    {
        return Contact::latest()
            ->take(5)
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'subject' => $contact->subject,
                    'time' => $contact->created_at->format('H:i'),
                    'date' => $contact->created_at->format('Y-m-d'),
                    'status' => $contact->status,
                ];
            })->toArray();
    }

    private function getRecentActivity()
    {
        // Get recent activities from various models
        $activities = collect();

        // Recent news
        $recentNews = News::latest()->take(3)->get();
        foreach ($recentNews as $news) {
            $activities->push([
                'id' => 'news_' . $news->id,
                'description' => "New article published: {$news->title}",
                'time' => $news->created_at->diffForHumans(),
                'type' => 'news'
            ]);
        }

        // Recent contacts
        $recentContacts = Contact::latest()->take(3)->get();
        foreach ($recentContacts as $contact) {
            $activities->push([
                'id' => 'contact_' . $contact->id,
                'description' => "New contact from: {$contact->name}",
                'time' => $contact->created_at->diffForHumans(),
                'type' => 'contact'
            ]);
        }

        // Recent registrations
        $recentRegistrations = ProgramRegistration::latest()->take(3)->get();
        foreach ($recentRegistrations as $registration) {
            $activities->push([
                'id' => 'registration_' . $registration->id,
                'description' => "New program registration: {$registration->name}",
                'time' => $registration->created_at->diffForHumans(),
                'type' => 'registration'
            ]);
        }

        return $activities->sortByDesc('time')->take(10)->values();
    }
}
