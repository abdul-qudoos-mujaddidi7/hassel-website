<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgriTechTool;
use App\Models\BeneficiariesStat;
use App\Models\CommunityProgram;
use App\Models\Contact;
use App\Models\EnvironmentalProject;
use App\Models\Gallery;
use App\Models\JobAnnouncement;
use App\Models\MarketAccessProgram;
use App\Models\News;
use App\Models\ProgramRegistration;
use App\Models\Publication;
use App\Models\RfpRfq;
use App\Models\SuccessStory;
use App\Models\TrainingProgram;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'content' => [
                'news' => News::count(),
                'publications' => Publication::count(),
                'successStories' => SuccessStory::count(),
                'galleries' => Gallery::count(),
                'jobs' => JobAnnouncement::count(),
                'rfps' => RfpRfq::count(),
            ],
            'engagement' => [
                'contacts' => Contact::count(),
                'registrations' => ProgramRegistration::count(),
                'beneficiaries' => BeneficiariesStat::sum('value'),
            ],
            'programs' => [
                'trainingPrograms' => TrainingProgram::count(),
                'agriTechTools' => AgriTechTool::count(),
                'marketAccessPrograms' => MarketAccessProgram::count(),
                'environmentalProjects' => EnvironmentalProject::count(),
                'communityPrograms' => CommunityProgram::count(),
            ],
        ];

        $latestNews = News::latest()->limit(5)->get();
        $latestContacts = Contact::latest()->limit(5)->get();
        $latestRegistrations = ProgramRegistration::with('program')->latest()->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'latestNews', 'latestContacts', 'latestRegistrations'));
    }

    public function analytics(): View
    {
        $newsByStatus = News::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $programsByStatus = TrainingProgram::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $registrationsByStatus = ProgramRegistration::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.dashboard.analytics', compact('newsByStatus', 'programsByStatus', 'registrationsByStatus'));
    }
}

