<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Requests\PublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Services\FileUploadService;

class AdminPublicationController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $type = $request->get('file_type');
        $search = $request->get('search');

        $query = Publication::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($type) {
            $query->where('file_type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $publications = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return PublicationResource::collection($publications);
    }

    public function store(PublicationRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $this->fileUploadService->upload(
                $request->file('file_path'),
                'document',
                'publications'
            );
        }

        $publication = Publication::create($data);

        return response()->json([
            'message' => 'Publication created successfully',
            'publication' => new PublicationResource($publication)
        ], 201);
    }

    public function show(Publication $publication): JsonResponse
    {
        return response()->json([
            'publication' => new PublicationResource($publication)
        ]);
    }

    public function update(PublicationRequest $request, Publication $publication): JsonResponse
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $this->fileUploadService->replace(
                $request->file('file_path'),
                'document',
                $publication->file_path,
                'publications'
            );
        }

        $publication->update($data);

        return response()->json([
            'message' => 'Publication updated successfully',
            'publication' => new PublicationResource($publication)
        ]);
    }

    public function destroy(Publication $publication): JsonResponse
    {
        // Delete associated file
        if ($publication->file_path) {
            $this->fileUploadService->delete($publication->file_path);
        }

        // Delete associated translations
        $publication->translations()->delete();

        $publication->delete();

        return response()->json([
            'message' => 'Publication deleted successfully'
        ]);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:publications,id',
            'action' => 'required|in:publish,unpublish,archive,delete',
        ]);

        $publications = Publication::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $publications->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $publications->update(['status' => 'draft']);
                break;
            case 'archive':
                $publications->update(['status' => 'archived']);
                break;
            case 'delete':
                foreach ($publications->get() as $publication) {
                    $this->destroy($publication);
                }
                break;
        }

        return response()->json([
            'message' => ucfirst($request->action) . ' operation completed successfully'
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total_publications' => Publication::count(),
            'published_publications' => Publication::published()->count(),
            'draft_publications' => Publication::draft()->count(),
            'publications_by_type' => Publication::selectRaw('file_type, count(*) as count')
                ->groupBy('file_type')
                ->pluck('count', 'file_type'),
        ]);
    }
}
