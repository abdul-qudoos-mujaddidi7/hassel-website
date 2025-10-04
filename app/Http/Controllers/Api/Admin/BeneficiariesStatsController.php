<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeneficiariesStatRequest;
use App\Models\BeneficiariesStat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeneficiariesStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 15);
            $search = $request->get('search', '');
            
            $query = BeneficiariesStat::query();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('stat_type', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            $beneficiariesStats = $query->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $beneficiariesStats->items(),
                'meta' => [
                    'total' => $beneficiariesStats->total(),
                    'per_page' => $beneficiariesStats->perPage(),
                    'current_page' => $beneficiariesStats->currentPage(),
                    'last_page' => $beneficiariesStats->lastPage(),
                ],
                'message' => 'Beneficiaries stats retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve beneficiaries stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BeneficiariesStatRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $beneficiariesStat = BeneficiariesStat::create($validated);

            return response()->json([
                'success' => true,
                'data' => $beneficiariesStat,
                'message' => 'Beneficiaries stat created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create beneficiaries stat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $beneficiariesStat,
                'message' => 'Beneficiaries stat retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve beneficiaries stat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BeneficiariesStatRequest $request, BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        try {
            $validated = $request->validated();
            $beneficiariesStat->update($validated);

            return response()->json([
                'success' => true,
                'data' => $beneficiariesStat,
                'message' => 'Beneficiaries stat updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update beneficiaries stat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        try {
            $beneficiariesStat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Beneficiaries stat deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete beneficiaries stat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics summary
     */
    public function summary(): JsonResponse
    {
        try {
            $summary = BeneficiariesStat::selectRaw('
                stat_type,
                COUNT(*) as total_records,
                AVG(value) as average_value,
                MIN(value) as min_value,
                MAX(value) as max_value,
                SUM(value) as total_value
            ')
            ->groupBy('stat_type')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $summary,
                'message' => 'Statistics summary retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
