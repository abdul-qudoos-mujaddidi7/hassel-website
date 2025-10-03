<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);

        // Attempt to log the user in
        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Login information is invalid!'], 401);
        }

        // Retrieve the authenticated user
        $user = User::where('email', $validated['email'])->first(); // Use first() to get the user instance

        // Generate an access token for the user
        $accessToken = $user->createToken('api_token')->plainTextToken;

       
        return response()->json([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'user' => [
                "id" => $user->id,
                "name" => $user->first_name,
                "email"=>$user->email,
                "photo" => $user->profile_picture ? asset("storage/" . $user->profile_picture) : null

            ],
                       
        ]);
        
    }

    public function logout(Request $request)
    {
        // Delete all tokens for the authenticated user
        $request->user()->tokens()->delete();

        // $user():currently authenticated user from the request.
        return response()->json(['message' => 'The user logged out']);
    }

    // Fixed password reset methods
public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email']);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'We could not find a user with that email address.',
            'status' => 'error'
        ], 404);
    }

    $status = Password::sendResetLink($request->only('email'));

    return response()->json([
        'message' => __($status),
        'status' => $status === Password::RESET_LINK_SENT ? 'success' : 'error'
    ], $status === Password::RESET_LINK_SENT ? 200 : 400);
}


public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return response()->json([
            'message' => __($status),
            'status' => 'success'
        ]);
    }

    return response()->json([
        'message' => __($status),
        'status' => 'error'
    ], 400);
}

    



    
}
