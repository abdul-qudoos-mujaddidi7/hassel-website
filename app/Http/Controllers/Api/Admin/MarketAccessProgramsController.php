<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketAccessProgramsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Market Access Programs management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create market access program - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show market access program - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update market access program - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete market access program - Coming soon']);
    }
}
