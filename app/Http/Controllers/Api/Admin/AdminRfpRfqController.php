<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RfpRfq;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RfpRfqRequest;
use App\Http\Resources\RfpRfqResource;

class AdminRfpRfqController extends Controller
{
    /**
     * Display a listing of RFPs/RFQs
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = RfpRfq::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $rfps = $query->orderBy('deadline', 'desc')
            ->paginate($request->get('per_page', 15));

        return RfpRfqResource::collection($rfps);
    }

    /**
     * Store a newly created RFP/RFQ
     */
    public function store(RfpRfqRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle document upload
        if ($request->hasFile('document_path')) {
            $documentPath = $request->file('document_path')->store('rfp-rfq', 'public');
            $data['document_path'] = $documentPath;
        }

        $rfp = RfpRfq::create($data);

        return response()->json([
            'message' => 'RFP/RFQ created successfully',
            'rfp' => new RfpRfqResource($rfp)
        ], 201);
    }

    /**
     * Display the specified RFP/RFQ
     */
    public function show(RfpRfq $rfpRfq): JsonResponse
    {
        return response()->json([
            'rfp' => new RfpRfqResource($rfpRfq)
        ]);
    }

    /**
     * Update the specified RFP/RFQ
     */
    public function update(RfpRfqRequest $request, RfpRfq $rfpRfq): JsonResponse
    {
        $data = $request->validated();

        // Handle document upload
        if ($request->hasFile('document_path')) {
            // Delete old document
            if ($rfpRfq->document_path) {
                Storage::disk('public')->delete($rfpRfq->document_path);
            }

            $documentPath = $request->file('document_path')->store('rfp-rfq', 'public');
            $data['document_path'] = $documentPath;
        }

        $rfpRfq->update($data);

        return response()->json([
            'message' => 'RFP/RFQ updated successfully',
            'rfp' => new RfpRfqResource($rfpRfq)
        ]);
    }

    /**
     * Remove the specified RFP/RFQ
     */
    public function destroy(RfpRfq $rfpRfq): JsonResponse
    {
        // Delete associated document
        if ($rfpRfq->document_path) {
            Storage::disk('public')->delete($rfpRfq->document_path);
        }

        $rfpRfq->delete();

        return response()->json([
            'message' => 'RFP/RFQ deleted successfully'
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:rfp_rfqs,id',
            'action' => 'required|in:publish,unpublish,archive,delete,close',
        ]);

        $rfps = RfpRfq::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $rfps->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $rfps->update(['status' => 'draft']);
                break;
            case 'archive':
                $rfps->update(['status' => 'archived']);
                break;
            case 'close':
                $rfps->update(['deadline' => now()->subDay()]);
                break;
            case 'delete':
                foreach ($rfps->get() as $rfp) {
                    $this->destroy($rfp);
                }
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
            'total_rfps' => RfpRfq::count(),
            'open_rfps' => RfpRfq::open()->count(),
            'closed_rfps' => RfpRfq::closed()->count(),
            'published_rfps' => RfpRfq::published()->count(),
        ]);
    }
}
