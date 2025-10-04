<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmartFarmingProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Smart Farming Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create smart farming program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show smart farming program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update smart farming program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete smart farming program - Coming soon']);
    }
}
