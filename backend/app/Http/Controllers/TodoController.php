<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{
    public function index(Request $request):JsonResponse
    {
        $todos = $request->user()->todos()->get();

        return response()->json([
            'todos' => $todos
        ], 200);
    }

    public function store(Request $request):JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        Todos::create([
            'title' => $request->name,
            'todos' => json_encode([]),
            'user_id' => $request->user()->id
        ]);

        return response()->json();
    }

    public function show(Request $request,$id):JsonResponse
    {
        return response()->json();
    }

    public function update():JsonResponse
    {
        return response()->json();
    }

    public function destroy():JsonResponse
    {
        return response()->json();
    }
}
