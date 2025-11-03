<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 15);
            $search = $request->get('search', '');
            $status = $request->get('status', '');
            $subject = $request->get('subject', '');
            
            $query = Contact::query();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            if ($subject) {
                $query->where('subject', $subject);
            }
            
            $contacts = $query->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $contacts->items(),
                'meta' => [
                    'total' => $contacts->total(),
                    'per_page' => $contacts->perPage(),
                    'current_page' => $contacts->currentPage(),
                    'last_page' => $contacts->lastPage(),
                ],
                'message' => 'Contacts retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contacts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $contact = Contact::create($validated);

            return response()->json([
                'success' => true,
                'data' => $contact,
                'message' => 'Contact created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $contact,
                'message' => 'Contact retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact): JsonResponse
    {
        try {
            $validated = $request->validated();
            $contact->update($validated);

            return response()->json([
                'success' => true,
                'data' => $contact,
                'message' => 'Contact updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark contact as read
     */
    public function markAsRead(Contact $contact): JsonResponse
    {
        try {
            $contact->update(['status' => 'read']);

            return response()->json([
                'success' => true,
                'data' => $contact,
                'message' => 'Contact marked as read successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark contact as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(Contact $contact): JsonResponse
    {
        try {
            $contact->update(['status' => 'replied']);

            return response()->json([
                'success' => true,
                'data' => $contact,
                'message' => 'Contact marked as replied successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark contact as replied',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get contact statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => Contact::count(),
                'new' => Contact::where('status', 'new')->count(),
                'read' => Contact::where('status', 'read')->count(),
                'replied' => Contact::where('status', 'replied')->count(),
                'archived' => Contact::where('status', 'archived')->count(),
                'by_subject' => Contact::selectRaw('subject, COUNT(*) as count')
                    ->groupBy('subject')
                    ->get()
                    ->pluck('count', 'subject')
                    ->toArray(),
                'recent' => Contact::where('created_at', '>=', now()->subDays(7))->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Contact statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
