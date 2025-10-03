<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgriTechToolsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Agri-Tech Tools management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create agri-tech tool - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show agri-tech tool - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update agri-tech tool - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete agri-tech tool - Coming soon']);
    }
}
