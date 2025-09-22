<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ContactResource;

class AdminContactController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Contact::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($contacts->through(fn($contact) => new ContactResource($contact)));
    }

    /**
     * Display the specified contact message
     */
    public function show(Contact $contact): JsonResponse
    {
        // Mark as read when viewed
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return response()->json([
            'contact' => new ContactResource($contact)
        ]);
    }

    /**
     * Update contact status
     */
    public function updateStatus(Request $request, Contact $contact): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied,resolved',
            'notes' => 'nullable|string|max:1000'
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'Contact status updated successfully',
            'contact' => new ContactResource($contact)
        ]);
    }

    /**
     * Remove the specified contact message
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact message deleted successfully'
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:contacts,id',
            'action' => 'required|in:mark_read,mark_unread,mark_replied,mark_resolved,delete',
        ]);

        $contacts = Contact::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'mark_read':
                $contacts->update(['status' => 'read']);
                break;
            case 'mark_unread':
                $contacts->update(['status' => 'unread']);
                break;
            case 'mark_replied':
                $contacts->update(['status' => 'replied']);
                break;
            case 'mark_resolved':
                $contacts->update(['status' => 'resolved']);
                break;
            case 'delete':
                $contacts->delete();
                break;
        }

        return response()->json([
            'message' => ucfirst($request->action) . ' operation completed successfully'
        ]);
    }

    /**
     * Dashboard stats
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total_messages' => Contact::count(),
            'unread_messages' => Contact::where('status', 'unread')->count(),
            'read_messages' => Contact::where('status', 'read')->count(),
            'replied_messages' => Contact::where('status', 'replied')->count(),
            'resolved_messages' => Contact::where('status', 'resolved')->count(),
            'recent_messages' => Contact::where('created_at', '>=', now()->subDays(7))->count(),
        ]);
    }

    /**
     * Export contact messages
     */
    public function export(Request $request): JsonResponse
    {
        $format = $request->get('format', 'csv');

        // This would typically generate a file and return a download link
        // For now, just return the data that would be exported
        $contacts = Contact::select(['name', 'email', 'subject', 'message', 'status', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Export ready',
            'format' => $format,
            'count' => $contacts->count(),
            'data' => $contacts
        ]);
    }
}
