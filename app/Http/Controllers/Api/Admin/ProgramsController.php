<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete program - Coming soon']);
    }
}
