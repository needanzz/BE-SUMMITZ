<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // Tampilkan semua trip
    public function index()
    {
        $trips = Trip::with(['mountain.province', 'schedules', 'itineraries', 'facilities', 'galleries', 'reviews'])
        ->withAvg('reviews', 'rating')
        ->orderByDesc('reviews_avg_rating')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $trips
        ]);
    }

    // Tampilkan detail trip berdasarkan ID
    public function show($id)
    {
        $trip = Trip::with(['mountain.province', 'schedules', 'itineraries', 'facilities', 'galleries', 'reviews'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $trip
        ]);
    }

    // Simpan trip baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mountain_id' => 'required|exists:mountains,id',
            'title' => 'required|string|max:255',
            'duration_day' => 'required|integer',
            'price' => 'required|numeric',
            'main_image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $trip = Trip::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $trip
        ], 201);
    }

    // Update trip
    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'mountain_id' => 'sometimes|exists:mountains,id',
            'title' => 'sometimes|string|max:255',
            'duration_day' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'main_image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $trip->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $trip
        ]);
    }

    // Hapus trip
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Trip deleted successfully'
        ]);
    }
}




// namespace App\Http\Controllers;

// use App\Models\Trip;
// use Illuminate\Http\Request;

// class TripController extends Controller
// {
//     public function index()
//     {
//         $trips = Trip::all();
//         return response (['data' => $trips ]);
//     }
// }