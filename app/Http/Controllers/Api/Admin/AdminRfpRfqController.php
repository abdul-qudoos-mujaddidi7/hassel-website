<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RfpRfq;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminRfpRfqController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = RfpRfq::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $rfps = $query->orderBy('deadline', 'desc')->paginate(15);
        return response()->json($rfps);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:rfps_rfqs,slug|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $rfp = RfpRfq::create($data);

        return response()->json(['message' => 'RFP/RFQ created', 'rfp' => $rfp], 201);
    }

    public function show(RfpRfq $rfpRfq): JsonResponse
    {
        return response()->json(['rfp' => $rfpRfq]);
    }

    public function update(Request $request, RfpRfq $rfpRfq): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:rfps_rfqs,slug,' . $rfpRfq->id,
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $rfpRfq->update($data);

        return response()->json(['message' => 'RFP/RFQ updated', 'rfp' => $rfpRfq->fresh()]);
    }

    public function destroy(RfpRfq $rfpRfq): JsonResponse
    {
        $rfpRfq->translations()->delete();
        $rfpRfq->delete();

        return response()->json(['message' => 'RFP/RFQ deleted']);
    }
}
