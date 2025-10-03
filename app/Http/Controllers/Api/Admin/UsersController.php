<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Users management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create user - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show user - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update user - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete user - Coming soon']);
    }
}
