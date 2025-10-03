<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvironmentalProjectsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Environmental Projects management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create environmental project - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show environmental project - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update environmental project - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete environmental project - Coming soon']);
    }
}
