<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketAccessProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MarketAccessProgramRequest;
use App\Http\Resources\MarketAccessProgramResource;

class AdminMarketAccessProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = MarketAccessProgram::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->program_type) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $programs = $query->with('registrations')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return MarketAccessProgramResource::collection($programs);
    }

    public function store(MarketAccessProgramRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('market-access-programs', 'public');
        }

        $program = MarketAccessProgram::create($data);

        return response()->json([
            'message' => 'Market access program created successfully',
            'program' => new MarketAccessProgramResource($program)
        ], 201);
    }

    public function show(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        return response()->json([
            'program' => new MarketAccessProgramResource($marketAccessProgram->load('registrations'))
        ]);
    }

    public function update(MarketAccessProgramRequest $request, MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($marketAccessProgram->image) {
                Storage::disk('public')->delete($marketAccessProgram->image);
            }
            $data['image'] = $request->file('image')->store('market-access-programs', 'public');
        }

        $marketAccessProgram->update($data);

        return response()->json([
            'message' => 'Market access program updated successfully',
            'program' => new MarketAccessProgramResource($marketAccessProgram)
        ]);
    }

    public function destroy(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        if ($marketAccessProgram->image) {
            Storage::disk('public')->delete($marketAccessProgram->image);
        }

        $marketAccessProgram->delete();

        return response()->json(['message' => 'Market access program deleted successfully']);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:market_access_programs,id',
            'action' => 'required|in:publish,unpublish,archive,delete',
        ]);

        $programs = MarketAccessProgram::whereIn('id', $request->ids);

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
            'total_programs' => MarketAccessProgram::count(),
            'published_programs' => MarketAccessProgram::published()->count(),
            'total_registrations' => MarketAccessProgram::withCount('registrations')->get()->sum('registrations_count'),
        ]);
    }
}
