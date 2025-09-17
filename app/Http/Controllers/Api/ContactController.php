<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ContactRequest;
use App\Services\EmailService;

class ContactController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    /**
     * Handle contact form submission
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        // Send email notifications
        $this->emailService->sendContactFormNotification($contact);
        $this->emailService->sendContactFormConfirmation($contact);

        return response()->json([
            'message' => 'Thank you for your message. We will get back to you soon.'
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
