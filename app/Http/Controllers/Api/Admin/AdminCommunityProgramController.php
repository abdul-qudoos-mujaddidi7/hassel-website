<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CommunityProgramRequest;
use App\Http\Resources\CommunityProgramResource;

class AdminCommunityProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = CommunityProgram::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->target_group) {
            $query->where('target_group', $request->target_group);
        }

        if ($request->program_type) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
                    ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        $programs = $query->with('registrations')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($programs->through(fn($program) => new CommunityProgramResource($program)));
    }

    public function store(CommunityProgramRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('community-programs', 'public');
        }

        $program = CommunityProgram::create($data);

        return response()->json([
            'message' => 'Community program created successfully',
            'program' => new CommunityProgramResource($program)
        ], 201);
    }

    public function show(CommunityProgram $communityProgram): JsonResponse
    {
        return response()->json([
            'program' => new CommunityProgramResource($communityProgram->load('registrations'))
        ]);
    }

    public function update(CommunityProgramRequest $request, CommunityProgram $communityProgram): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($communityProgram->featured_image) {
                Storage::disk('public')->delete($communityProgram->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('community-programs', 'public');
        }

        $communityProgram->update($data);

        return response()->json([
            'message' => 'Community program updated successfully',
            'program' => new CommunityProgramResource($communityProgram)
        ]);
    }

    public function destroy(CommunityProgram $communityProgram): JsonResponse
    {
        if ($communityProgram->featured_image) {
            Storage::disk('public')->delete($communityProgram->featured_image);
        }

        $communityProgram->delete();

        return response()->json(['message' => 'Community program deleted successfully']);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:community_programs,id',
            'action' => 'required|in:publish,unpublish,archive,delete,mark_completed',
        ]);

        $programs = CommunityProgram::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $programs->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $programs->update(['status' => 'draft']);
                break;
            case 'archive':
                $programs->update(['status' => 'archived']);
                break;
            case 'mark_completed':
                $programs->update(['end_date' => now()]);
                break;
            case 'delete':
                foreach ($programs->get() as $program) {
                    $this->destroy($program);
                }
                break;
        }

        return response()->json(['message' => ucfirst($request->action) . ' operation completed successfully']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total_programs' => CommunityProgram::count(),
            'ongoing_programs' => CommunityProgram::ongoing()->count(),
            'completed_programs' => CommunityProgram::completed()->count(),
            'total_registrations' => CommunityProgram::withCount('registrations')->get()->sum('registrations_count'),
            'programs_by_target_group' => CommunityProgram::selectRaw('target_group, count(*) as count')
                ->groupBy('target_group')
                ->pluck('count', 'target_group'),
        ]);
    }
}
