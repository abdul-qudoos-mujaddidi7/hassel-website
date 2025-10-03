<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Jobs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create job - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show job - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update job - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete job - Coming soon']);
    }
}
