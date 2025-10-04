<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ContactRequest;
use App\Services\EmailService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:255',
                'subject' => 'required|in:job_application,technical_support,partnership,project_discussion,general_inquiry,media_inquiry,other',
                'message' => 'required|string',
                'job_title' => 'nullable|string|max:255',
                'job_id' => 'nullable|exists:job_announcements,id',
                'location' => 'nullable|string|max:255',
                'cover_letter' => 'nullable|string',
                'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            ]);

            // Handle CV file upload for job applications
            if ($request->hasFile('cv_file') && $data['subject'] === 'job_application') {
                $file = $request->file('cv_file');
                $filename = Str::slug($data['name']) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('cv_uploads', $filename, 'public');
                $data['cv_file_path'] = $path;
            }

            $contact = Contact::create($data);

            // Send email notifications
            $this->emailService->sendContactFormNotification($contact);
            $this->emailService->sendContactFormConfirmation($contact);

            return response()->json([
                'message' => $data['subject'] === 'job_application'
                    ? 'Thank you for your job application. We will review your application and get back to you soon.'
                    : 'Thank you for your message. We will get back to you soon.'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
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
