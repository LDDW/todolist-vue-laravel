<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request):JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|same:password',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed to validate user',
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'errors' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'User created successfully',
        ], 201);
    }

    public function login(Request $request):JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed to validate user',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if($user && Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'connexion réussite',
                'token' => $user->createToken('auth_token')->plainTextToken
            ], 200);
        }

        return response()->json([
            'message' => 'Connexion échouée',
            'errors' => 'Email ou mot de passe incorrect',
        ], 401);
    }

    public function logout(Request $request):JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successfully',
        ], 200);
    }
}
