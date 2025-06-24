<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    // Get all provinces
    public function index()
    {
        return response()->json(Province::all());
    }

    // Store new province
    public function store(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
        ]);

        $province = Province::create([
            'province_name' => $request->province_name,
        ]);

        return response()->json($province, 201);
    }

    // Get detail province
    public function show($id)
    {
        $province = Province::with('mountains')->findOrFail($id);
        return response()->json($province);
    }

    // Update province
    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);

        $request->validate([
            'province_name' => 'required|string|max:255',
        ]);

        $province->update([
            'province_name' => $request->province_name,
        ]);

        return response()->json($province);
    }

    // Delete province
    public function destroy($id)
    {
        Province::destroy($id);
        return response()->json(['message' => 'Province deleted']);
    }
}
