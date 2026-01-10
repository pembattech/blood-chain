<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    // REGISTER USER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'role' => 'in:donor,recipient,admin',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'blood_type' => $request->blood_type,
            'role' => $request->role ?? 'donor',
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // LOGIN USER
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        // Check if user has completed donor profile
        $profileMessage = $user->isProfileComplete()
            ? '✅ Donor profile already exists.'
            : '⛔ Please complete donor profile.';

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'is_admin' => $user->role === 'admin' ? true : false,
            'token' => $token,
            'profile_status' => $user->isProfileComplete(),
            'message' => $profileMessage,
        ]);
    }

    // LOGOUT USER
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
