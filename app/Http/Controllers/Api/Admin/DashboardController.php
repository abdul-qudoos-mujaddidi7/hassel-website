<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\TrainingProgram;
use App\Models\Contact;
use App\Models\ProgramRegistration;
use App\Models\User;

class DashboardController extends Controller
{
    public function stats()
    {
        try {
            $stats = [
                'totalUsers' => User::count(),
                'totalPrograms' => TrainingProgram::count(),
                'totalNews' => News::count(),
                'totalContacts' => Contact::count(),
                'totalRegistrations' => ProgramRegistration::count(),
                'recentActivity' => $this->getRecentActivity()
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch dashboard statistics'], 500);
        }
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
