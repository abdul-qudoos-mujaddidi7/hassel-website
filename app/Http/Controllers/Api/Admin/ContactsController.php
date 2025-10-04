<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Contacts management - Coming soon']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Create contact - Coming soon']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Show contact - Coming soon']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Update contact - Coming soon']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Delete contact - Coming soon']);
    }
}
