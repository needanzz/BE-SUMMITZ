<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();

        return response()->json([
            'status' => 'success',
            'data' => $galleries,
        ]);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $gallery,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'image_path' => 'required|array',
            'image_path.*' => 'string', // setiap item array harus string (path URL/image name)
        ]);

        $gallery = Gallery::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $gallery,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'trip_id' => 'sometimes|exists:trips,id',
            'image_path' => 'sometimes|array',
            'image_path.*' => 'string',
        ]);

        $gallery->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $gallery,
        ]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Gallery deleted successfully',
        ]);
    }
}
