<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RfpRfq;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RfpRfqResource;

class RfpRfqController extends Controller
{
    /**
     * Get RFPs/RFQs list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status', 'open'); // open, closed, all

        $query = RfpRfq::published();

        // Apply status filter
        switch ($status) {
            case 'open':
                $query->open();
                break;
            case 'closed':
                $query->closed();
                break;
            default:
                // Show all published RFPs/RFQs
                break;
        }

        $rfps = $query->orderBy('deadline', 'desc')->paginate(12);

        return RfpRfqResource::collection($rfps);
    }

    /**
     * Get single RFP/RFQ details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $rfp = RfpRfq::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json(['rfp' => new RfpRfqResource($rfp)]);
    }
}
