<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Training Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create training program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show training program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update training program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete training program - Coming soon']);
    }
}
