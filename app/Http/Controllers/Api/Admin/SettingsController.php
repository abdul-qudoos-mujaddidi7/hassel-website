<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Settings management - Coming soon']);
    }

    public function update(Request $request)
    {
        return response()->json(['message' => 'Update settings - Coming soon']);
    }

    public function clearCache()
    {
        return response()->json(['message' => 'Clear cache - Coming soon']);
    }
}
