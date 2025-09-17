<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminCommunityProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = CommunityProgram::with('registrations');

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
            'slug' => 'nullable|string|unique:community_programs,slug|max:255',
            'description' => 'required|string',
            'program_type' => 'required|in:capacity_building,financial_literacy,leadership,entrepreneurship,cooperative',
            'target_group' => 'required|in:women,youth,cooperatives,farmers,all',
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

        $program = CommunityProgram::create($data);

        return response()->json(['message' => 'Community program created', 'program' => $program], 201);
    }

    public function show(CommunityProgram $communityProgram): JsonResponse
    {
        return response()->json(['program' => $communityProgram->load('registrations')]);
    }

    public function update(Request $request, CommunityProgram $communityProgram): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:community_programs,slug,' . $communityProgram->id,
            'description' => 'required|string',
            'program_type' => 'required|in:capacity_building,financial_literacy,leadership,entrepreneurship,cooperative',
            'target_group' => 'required|in:women,youth,cooperatives,farmers,all',
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

        $communityProgram->update($data);

        return response()->json(['message' => 'Community program updated', 'program' => $communityProgram->fresh()]);
    }

    public function destroy(CommunityProgram $communityProgram): JsonResponse
    {
        $communityProgram->translations()->delete();
        $communityProgram->registrations()->delete();
        $communityProgram->delete();

        return response()->json(['message' => 'Community program deleted']);
    }
}
