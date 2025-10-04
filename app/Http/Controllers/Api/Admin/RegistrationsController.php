<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Registrations management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create registration - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show registration - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update registration - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete registration - Coming soon']);
    }
}
