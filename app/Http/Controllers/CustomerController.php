<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'status' => 'success',
            'data' => $customers,
        ]);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $customer,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cust_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $customer = Customer::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $customer,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'cust_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customers,email,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $customer->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $customer,
        ]);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully',
        ]);
    }
}
