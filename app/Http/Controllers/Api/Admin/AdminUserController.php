<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
  /**
   * Display a listing of users
   */
  public function index(Request $request): JsonResponse
  {
    $query = User::query();

    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%");
      });
    }

    if ($request->has('is_admin')) {
      $query->where('is_admin', $request->boolean('is_admin'));
    }

    $users = $query->orderBy('created_at', 'desc')
      ->paginate($request->get('per_page', 15));

    return response()->json($users);
  }

  /**
   * Store a newly created user
   */
  public function store(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'is_admin' => 'boolean',
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'is_admin' => $request->boolean('is_admin', false),
      'email_verified_at' => now(),
    ]);

    return response()->json([
      'message' => 'User created successfully',
      'user' => $user->makeHidden(['password'])
    ], 201);
  }

  /**
   * Display the specified user
   */
  public function show(User $user): JsonResponse
  {
    return response()->json([
      'user' => $user->makeHidden(['password'])
    ]);
  }

  /**
   * Update the specified user
   */
  public function update(Request $request, User $user): JsonResponse
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'password' => 'nullable|string|min:8|confirmed',
      'is_admin' => 'boolean',
    ]);

    $data = [
      'name' => $request->name,
      'email' => $request->email,
      'is_admin' => $request->boolean('is_admin', false),
    ];

    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return response()->json([
      'message' => 'User updated successfully',
      'user' => $user->makeHidden(['password'])
    ]);
  }

  /**
   * Remove the specified user
   */
  public function destroy(User $user): JsonResponse
  {
    // Prevent deletion of the last admin user
    if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
      return response()->json([
        'message' => 'Cannot delete the last admin user'
      ], 422);
    }

    $user->delete();

    return response()->json([
      'message' => 'User deleted successfully'
    ]);
  }

  /**
   * Bulk operations
   */
  public function bulkUpdate(Request $request): JsonResponse
  {
    $request->validate([
      'ids' => 'required|array',
      'ids.*' => 'integer|exists:users,id',
      'action' => 'required|in:make_admin,remove_admin,delete',
    ]);

    $users = User::whereIn('id', $request->ids);

    switch ($request->action) {
      case 'make_admin':
        $users->update(['is_admin' => true]);
        break;
      case 'remove_admin':
        // Prevent removing admin from all users
        $adminCount = User::where('is_admin', true)->count();
        $targetCount = $users->where('is_admin', true)->count();

        if ($adminCount - $targetCount < 1) {
          return response()->json([
            'message' => 'Cannot remove admin privileges from all admin users'
          ], 422);
        }

        $users->update(['is_admin' => false]);
        break;
      case 'delete':
        // Check if we're trying to delete all admin users
        $adminUsersToDelete = $users->where('is_admin', true)->count();
        $totalAdmins = User::where('is_admin', true)->count();

        if ($adminUsersToDelete >= $totalAdmins) {
          return response()->json([
            'message' => 'Cannot delete all admin users'
          ], 422);
        }

        $users->delete();
        break;
    }

    return response()->json([
      'message' => ucfirst($request->action) . ' operation completed successfully'
    ]);
  }

  /**
   * Dashboard stats
   */
  public function stats(): JsonResponse
  {
    return response()->json([
      'total_users' => User::count(),
      'admin_users' => User::where('is_admin', true)->count(),
      'regular_users' => User::where('is_admin', false)->count(),
      'recent_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
    ]);
  }
}
