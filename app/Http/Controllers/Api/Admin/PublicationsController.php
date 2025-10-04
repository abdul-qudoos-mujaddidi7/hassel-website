<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Publications management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create publication - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show publication - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update publication - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete publication - Coming soon']);
    }
}
