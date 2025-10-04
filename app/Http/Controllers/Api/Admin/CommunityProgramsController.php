<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Community Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create community program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show community program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update community program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete community program - Coming soon']);
    }
}
