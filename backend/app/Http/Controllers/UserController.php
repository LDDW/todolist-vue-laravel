<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show():JsonResponse
    {
        return response()->json();
    }

    public function updateUser(Request $request):JsonResponse
    {
        return response()->json();
    }

    public function updatePassword(Request $request):JsonResponse
    {
        return response()->json();
    }

    public function destroy():JsonResponse
    {
        return response()->json();
    }
}
