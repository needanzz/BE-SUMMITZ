<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->has('trip_id')) {
            $query->where('trip_id', $request->trip_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    public function show($id)
    {
        $facility = Facility::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $facility
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'item' => 'required|string',
        ]);

        $facility = Facility::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $facility
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $validated = $request->validate([
            'trip_id' => 'sometimes|exists:trips,id',
            'item' => 'sometimes|string',
        ]);

        $facility->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $facility
        ]);
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Facility deleted successfully'
        ]);
    }
}
