<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\JobListing;
use App\Models\Contact;
use Illuminate\Http\Request;

class SiteController extends Controller
{
  public function home()
  {
    return response()->json([
      'hero' => [
        'title' => 'Inclusive Finance for Sustainable Growth',
        'subtitle' => 'We empower farmers and entrepreneurs through Sharia-compliant and conventional financial products.',
        'images' => [
          'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1600&q=80',
          'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=1600&q=80',
          'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1600&q=80',
        ]
      ],
      'stats' => [
        ['label' => 'Beneficiaries', 'value' => 15000, 'icon' => 'fa-solid fa-people-group'],
        ['label' => 'Projects', 'value' => 120, 'icon' => 'fa-solid fa-diagram-project'],
        ['label' => 'Staff', 'value' => 75, 'icon' => 'fa-solid fa-user-tie'],
        ['label' => 'Regions', 'value' => 10, 'icon' => 'fa-solid fa-location-dot'],
      ]
    ]);
  }

  public function about()
  {
    return response()->json([
      'title' => 'About MAI',
      'content' => 'Mount Agro Institution (MAI) advances financial inclusion...'
    ]);
  }

  public function news()
  {
    $news = News::published()
      ->orderBy('published_at', 'desc')
      ->limit(6)
      ->get();

    return response()->json([
      'news' => $news
    ]);
  }

  public function jobs()
  {
    $jobs = JobListing::active()
      ->orderBy('created_at', 'desc')
      ->get();

    return response()->json([
      'jobs' => $jobs
    ]);
  }

  public function contact(Request $request)
  {
    $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'nullable|string|max:20',
      'subject' => 'required|string|max:255',
      'message' => 'required|string',
    ]);

    Contact::create($request->all());

    return response()->json([
      'message' => 'Thank you for your message. We will get back to you soon.'
    ]);
  }
}
