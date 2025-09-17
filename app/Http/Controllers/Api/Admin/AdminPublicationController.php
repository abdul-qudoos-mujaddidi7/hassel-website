<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPublicationController extends Controller
{
    /**
     * Display a listing of publications
     */
    public function index(Request $request): JsonResponse
    {
        $query = Publication::query();

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('file_type')) {
            $query->where('file_type', $request->file_type);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $publications = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($publications);
    }

    /**
     * Store a newly created publication
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:publications,slug|max:255',
            'description' => 'required|string|max:1000',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'file_type' => 'required|in:report,manual,guideline,policy,research,other',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('publications', 'public');
            $data['file_path'] = $filePath;
        }

        // Set published_at if status is published and no date provided
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $publication = Publication::create($data);

        return response()->json([
            'message' => 'Publication created successfully',
            'publication' => $publication
        ], 201);
    }

    /**
     * Display the specified publication
     */
    public function show(Publication $publication): JsonResponse
    {
        return response()->json(['publication' => $publication]);
    }

    /**
     * Update the specified publication
     */
    public function update(Request $request, Publication $publication): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:publications,slug,' . $publication->id . '|max:255',
            'description' => 'required|string|max:1000',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'file_type' => 'required|in:report,manual,guideline,policy,research,other',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle file upload
        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($publication->file_path) {
                Storage::disk('public')->delete($publication->file_path);
            }
            $filePath = $request->file('file_path')->store('publications', 'public');
            $data['file_path'] = $filePath;
        }

        // Set published_at if status changed to published and no date provided
        if ($data['status'] === 'published' && $publication->status !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $publication->update($data);

        return response()->json([
            'message' => 'Publication updated successfully',
            'publication' => $publication->fresh()
        ]);
    }

    /**
     * Remove the specified publication
     */
    public function destroy(Publication $publication): JsonResponse
    {
        // Delete file if exists
        if ($publication->file_path) {
            Storage::disk('public')->delete($publication->file_path);
        }

        // Delete associated translations
        $publication->translations()->delete();

        $publication->delete();

        return response()->json([
            'message' => 'Publication deleted successfully'
        ]);
    }

    /**
     * Get publication statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => Publication::count(),
            'published' => Publication::published()->count(),
            'draft' => Publication::draft()->count(),
            'archived' => Publication::where('status', 'archived')->count(),
            'by_type' => Publication::selectRaw('file_type, count(*) as count')
                ->groupBy('file_type')
                ->get()
                ->pluck('count', 'file_type'),
        ]);
    }
}
