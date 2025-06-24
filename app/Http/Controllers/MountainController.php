<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;

class MountainController extends Controller
{
    // GET: /api/mountains
    public function index()
    {
        return response()->json(Mountain::with('province')->get());
    }

    // POST: /api/mountains
    public function store(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'mountain_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mountain = Mountain::create($request->only('province_id', 'mountain_name', 'description'));

        return response()->json($mountain, 201);
    }

    // GET: /api/mountains/{id}
    public function show($id)
    {
        $mountain = Mountain::with(['province', 'trips'])->findOrFail($id);
        return response()->json($mountain);
    }

    // PUT: /api/mountains/{id}
    public function update(Request $request, $id)
    {
        $mountain = Mountain::findOrFail($id);

        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'mountain_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mountain->update($request->only('province_id', 'mountain_name', 'description'));

        return response()->json($mountain);
    }

    // DELETE: /api/mountains/{id}
    public function destroy($id)
    {
        Mountain::destroy($id);
        return response()->json(['message' => 'Mountain deleted']);
    }
}
