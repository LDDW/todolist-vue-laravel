<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }

    public function updateUser(Request $request):JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->user()->id,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            $request->user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'errors' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'User updated successfully',
        ], 201);
    }

    public function updatePassword(Request $request):JsonResponse
    {
        try {
            $request->validate([
                'new_password' => 'required|string|min:8|different:old_password',
                'confirm_new_password' => 'required|string|min:8|same:new_password',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed to update password',
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            $user = User::find($request->user()->id);

            if(!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'message' => 'failed update password',
                ], 422);
            } else {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update password',
                'errors' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Password updated successfully',
        ], 201);
    }

    public function destroy(Request $request):JsonResponse
    {
        try {
            $request->user()->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'errors' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'User deleted successfully',
        ], 201);
    }
}