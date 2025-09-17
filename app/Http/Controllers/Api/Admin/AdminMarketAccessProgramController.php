<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketAccessProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminMarketAccessProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = MarketAccessProgram::with('registrations');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($programs);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:market_access_programs,slug|max:255',
            'description' => 'required|string',
            'program_type' => 'required|in:market_linkage,value_chain,export_support,cooperative_development',
            'target_crops' => 'nullable|json',
            'partner_organizations' => 'nullable|json',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $program = MarketAccessProgram::create($data);

        return response()->json(['message' => 'Market access program created', 'program' => $program], 201);
    }

    public function show(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        return response()->json(['program' => $marketAccessProgram->load('registrations')]);
    }

    public function update(Request $request, MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:market_access_programs,slug,' . $marketAccessProgram->id,
            'description' => 'required|string',
            'program_type' => 'required|in:market_linkage,value_chain,export_support,cooperative_development',
            'target_crops' => 'nullable|json',
            'partner_organizations' => 'nullable|json',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $marketAccessProgram->update($data);

        return response()->json(['message' => 'Market access program updated', 'program' => $marketAccessProgram->fresh()]);
    }

    public function destroy(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $marketAccessProgram->translations()->delete();
        $marketAccessProgram->registrations()->delete();
        $marketAccessProgram->delete();

        return response()->json(['message' => 'Market access program deleted']);
    }
}
