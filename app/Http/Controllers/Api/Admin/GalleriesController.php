<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Galleries management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create gallery - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show gallery - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update gallery - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete gallery - Coming soon']);
    }
}
