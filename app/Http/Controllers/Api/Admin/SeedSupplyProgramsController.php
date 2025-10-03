<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeedSupplyProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Seed Supply Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create seed supply program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show seed supply program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update seed supply program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete seed supply program - Coming soon']);
    }
}
