<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashbaordController extends Controller
{
    public function index(Request $request):JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
            'todolists' => $request->user()->todos()->get(),
        ], 200);
    }
}
