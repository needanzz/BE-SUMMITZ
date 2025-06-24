<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    // Ambil semua itinerary (opsional: bisa pakai query trip_id)
    public function index(Request $request)
    {
        $query = Itinerary::query();

        if ($request->has('trip_id')) {
            $query->where('trip_id', $request->trip_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    // Ambil detail itinerary
    public function show($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $itinerary
        ]);
    }

    // Simpan itinerary baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'day' => 'required|integer',
            'activity' => 'required|string',
        ]);

        $itinerary = Itinerary::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $itinerary
        ], 201);
    }

    // Update itinerary
    public function update(Request $request, $id)
    {
        $itinerary = Itinerary::findOrFail($id);

        $validated = $request->validate([
            'day' => 'sometimes|integer',
            'activity' => 'sometimes|string',
            'trip_id' => 'sometimes|exists:trips,id',
        ]);

        $itinerary->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $itinerary
        ]);
    }

    // Hapus itinerary
    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Itinerary deleted successfully'
        ]);
    }
}

