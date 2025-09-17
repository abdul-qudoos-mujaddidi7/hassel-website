<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeneficiariesStat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminStatsController extends Controller
{
    /**
     * Display a listing of statistics
     */
    public function index(Request $request): JsonResponse
    {
        $query = BeneficiariesStat::query();

        if ($request->has('stat_type')) {
            $query->where('stat_type', $request->stat_type);
        }

        if ($request->has('year')) {
            $query->forYear($request->year);
        }

        $stats = $query->orderBy('year', 'desc')
            ->orderBy('stat_type')
            ->paginate($request->get('per_page', 15));

        return response()->json($stats);
    }

    /**
     * Store a newly created statistic
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'stat_type' => 'required|in:beneficiaries,loans_disbursed,training_participants,cooperatives_formed,jobs_created',
            'value' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 5),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check for duplicate stat_type and year combination
        $exists = BeneficiariesStat::where('stat_type', $request->stat_type)
            ->where('year', $request->year)
            ->exists();

        if ($exists) {
            return response()->json([
                'errors' => ['stat_type' => ['A statistic for this type and year already exists.']]
            ], 422);
        }

        $stat = BeneficiariesStat::create($validator->validated());

        return response()->json([
            'message' => 'Statistic created successfully',
            'stat' => $stat
        ], 201);
    }

    /**
     * Display the specified statistic
     */
    public function show(BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        return response()->json(['stat' => $beneficiariesStat]);
    }

    /**
     * Update the specified statistic
     */
    public function update(Request $request, BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'stat_type' => 'required|in:beneficiaries,loans_disbursed,training_participants,cooperatives_formed,jobs_created',
            'value' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 5),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check for duplicate stat_type and year combination (excluding current record)
        $exists = BeneficiariesStat::where('stat_type', $request->stat_type)
            ->where('year', $request->year)
            ->where('id', '!=', $beneficiariesStat->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'errors' => ['stat_type' => ['A statistic for this type and year already exists.']]
            ], 422);
        }

        $beneficiariesStat->update($validator->validated());

        return response()->json([
            'message' => 'Statistic updated successfully',
            'stat' => $beneficiariesStat->fresh()
        ]);
    }

    /**
     * Remove the specified statistic
     */
    public function destroy(BeneficiariesStat $beneficiariesStat): JsonResponse
    {
        $beneficiariesStat->translations()->delete();
        $beneficiariesStat->delete();

        return response()->json([
            'message' => 'Statistic deleted successfully'
        ]);
    }

    /**
     * Get statistics summary
     */
    public function summary(): JsonResponse
    {
        return response()->json([
            'total_stats' => BeneficiariesStat::count(),
            'current_year_stats' => BeneficiariesStat::forYear(date('Y'))->count(),
            'years_covered' => BeneficiariesStat::distinct()->pluck('year')->sort()->values(),
            'stat_types' => BeneficiariesStat::distinct()->pluck('stat_type')->sort()->values(),
            'latest_updates' => BeneficiariesStat::orderBy('updated_at', 'desc')->limit(5)->get(),
        ]);
    }
}
