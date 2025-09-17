<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminSuccessStoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = SuccessStory::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('client_name', 'like', '%' . $request->search . '%');
            });
        }

        $stories = $query->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($stories);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:success_stories,slug|max:255',
            'client_name' => 'required|string|max:255',
            'story' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('success-stories', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $story = SuccessStory::create($data);

        return response()->json(['message' => 'Success story created', 'story' => $story], 201);
    }

    public function show(SuccessStory $successStory): JsonResponse
    {
        return response()->json(['story' => $successStory]);
    }

    public function update(Request $request, SuccessStory $successStory): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:success_stories,slug,' . $successStory->id,
            'client_name' => 'required|string|max:255',
            'story' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            if ($successStory->image) {
                Storage::disk('public')->delete($successStory->image);
            }
            $data['image'] = $request->file('image')->store('success-stories', 'public');
        }

        $successStory->update($data);

        return response()->json(['message' => 'Success story updated', 'story' => $successStory->fresh()]);
    }

    public function destroy(SuccessStory $successStory): JsonResponse
    {
        if ($successStory->image) {
            Storage::disk('public')->delete($successStory->image);
        }

        $successStory->translations()->delete();
        $successStory->delete();

        return response()->json(['message' => 'Success story deleted']);
    }
}
