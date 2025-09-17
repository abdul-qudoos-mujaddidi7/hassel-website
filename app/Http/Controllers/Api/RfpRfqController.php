<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RfpRfq;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RfpRfqController extends Controller
{
    /**
     * Get RFPs/RFQs list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
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

        // Apply translations if needed
        if ($language !== 'en') {
            $rfps->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($rfps);
    }

    /**
     * Get single RFP/RFQ details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $rfp = RfpRfq::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $rfp->title = $rfp->getTranslation('title', $language);
            $rfp->description = $rfp->getTranslation('description', $language);
        }

        // Add computed properties
        $rfp->is_open = $rfp->is_open;
        $rfp->is_expired = $rfp->is_expired;
        $rfp->days_remaining = $rfp->days_remaining;

        return response()->json(['rfp' => $rfp]);
    }
}
