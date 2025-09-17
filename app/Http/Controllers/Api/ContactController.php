<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new'
        ]);

        return response()->json([
            'message' => 'Thank you for your message. We will get back to you soon.',
            'contact_id' => $contact->id
        ], 201);
    }

    /**
     * Get contact information (office locations, etc.)
     */
    public function info(): JsonResponse
    {
        return response()->json([
            'offices' => [
                [
                    'name' => 'Head Office - Kabul',
                    'address' => 'Kabul, Afghanistan',
                    'phone' => '+93 XX XXX XXXX',
                    'email' => 'info@mountagro.af',
                    'hours' => 'Sunday - Thursday: 8:00 AM - 5:00 PM'
                ],
                [
                    'name' => 'Regional Office - Herat',
                    'address' => 'Herat, Afghanistan',
                    'phone' => '+93 XX XXX XXXX',
                    'email' => 'herat@mountagro.af',
                    'hours' => 'Sunday - Thursday: 8:00 AM - 5:00 PM'
                ]
            ],
            'general_contact' => [
                'email' => 'info@mountagro.af',
                'phone' => '+93 XX XXX XXXX',
                'website' => 'https://mountagro.af'
            ],
            'social_media' => [
                'facebook' => 'https://facebook.com/mountagro',
                'twitter' => 'https://twitter.com/mountagro',
                'linkedin' => 'https://linkedin.com/company/mountagro'
            ]
        ]);
    }
}
