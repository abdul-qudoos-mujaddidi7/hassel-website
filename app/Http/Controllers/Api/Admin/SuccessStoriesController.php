<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuccessStoriesController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Success Stories management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create success story - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show success story - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update success story - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete success story - Coming soon']);
    }
}
