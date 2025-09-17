<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminContactController extends Controller
{
    /**
     * Display a listing of contact submissions
     */
    public function index(Request $request): JsonResponse
    {
        $query = Contact::query();

        // Apply filters
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($contacts);
    }

    /**
     * Display the specified contact submission
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json(['contact' => $contact]);
    }

    /**
     * Remove the specified contact submission
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact submission deleted successfully'
        ]);
    }

    /**
     * Bulk delete contact submissions
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $count = Contact::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => "{$count} contact submissions deleted successfully"
        ]);
    }

    /**
     * Get contact statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => Contact::count(),
            'this_month' => Contact::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'this_week' => Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'today' => Contact::whereDate('created_at', today())->count(),
        ]);
    }

    /**
     * Export contact submissions to CSV
     */
    public function export(Request $request): JsonResponse
    {
        $query = Contact::query();

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        // In a real implementation, you would generate and return a CSV file
        // For now, return the data that could be exported
        return response()->json([
            'message' => 'Export data prepared',
            'count' => $contacts->count(),
            'data' => $contacts->map(function ($contact) {
                return [
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'subject' => $contact->subject,
                    'message' => $contact->message,
                    'created_at' => $contact->created_at->format('Y-m-d H:i:s'),
                ];
            })
        ]);
    }
}
