<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Midtrans\Snap;
use App\Models\Payment;
use Midtrans\Config;

class BookingController extends Controller
{
    // Ambil semua data booking
    public function index()
    {
        return response()->json([
            'data' => Booking::with(['user', 'schedule'])->get()
        ]);
    }

    // Simpan booking baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'schedule_id'    => 'required|exists:schedules,id',
        'customer_name'  => 'required|string|max:100',
        'customer_email' => 'required|email:rfc,dns',
        'quantity'       => 'required|integer|min:1',
    ]);

    $user = auth()->user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $schedule = Schedule::with('trip')->findOrFail($validated['schedule_id']);
    if (!$schedule->trip) {
        return response()->json(['message' => 'Trip not found'], 404);
    }

    $total_price = $schedule->trip->price * $validated['quantity'];

    $booking = Booking::create([
        'user_id'        => $user->id,
        'schedule_id'    => $validated['schedule_id'],
        'customer_name'  => $validated['customer_name'],
        'customer_email' => $validated['customer_email'],
        'quantity'       => $validated['quantity'],
        'total_price'    => $total_price,
    ]);

    // load relasi untuk output lebih lengkap
    $booking->load(['user', 'schedule.trip']);

    // Midtrans order_id unik
    $order_id = 'ORDER-'.$booking->id.'-'.time();

    // Parameter snap
    $params = [
        'transaction_details' => [
            'order_id'     => $order_id,
            'gross_amount' => $total_price,
        ],
        'customer_details' => [
            'first_name' => $validated['customer_name'],
            'email'      => $validated['customer_email'],
        ],
        'item_details' => [[
            'id'       => $booking->id,
            'price'    => $total_price,
            'quantity' => 1,
            'name'     => 'Booking trip '.$booking->id,
        ]],
    ];

    // Buat snap token
    $snap_token = Snap::getSnapToken($params);

    // Simpan payment
    Payment::create([
        'booking_id'     => $booking->id,
        'order_id'       => $order_id,
        'payment_method' => 'midtrans',
        'payment_status' => 'pending',
        'gross_amount'   => $total_price,
    ]);

    return response()->json([
        'message' => 'Booking created successfully',
        'data'    => $booking,
        'snapToken' => $snap_token,
    ], 201);
}


    // Ambil detail booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'schedule'])->findOrFail($id);
        return response()->json(['data' => $booking]);
    }

    public function update(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    // optional auth check
    if ($booking->user_id !== auth()->id()) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $validated = $request->validate([
        'schedule_id'    => 'sometimes|exists:schedules,id',
        'customer_name'  => 'sometimes|string|max:100',
        'customer_email' => 'sometimes|email:rfc,dns',
        'quantity'       => 'sometimes|integer|min:1',
    ]);

    // Jika schedule_id diubah, cari harga baru
    $scheduleId = $validated['schedule_id'] ?? $booking->schedule_id;
    $quantity   = $validated['quantity'] ?? $booking->quantity;

    $schedule = Schedule::with('trip')->findOrFail($scheduleId);
    $validated['total_price'] = $schedule->trip->price * $quantity;

    $booking->update($validated);

    // load relasi untuk respons lebih lengkap
    $booking->load(['user', 'schedule.trip']);

    return response()->json([
        'message' => 'Booking updated successfully',
        'data'    => $booking,
    ]);
}


    // Hapus booking
public function destroy($id)
{
    $booking = Booking::findOrFail($id);

    // Optional: cek kepemilikan
    if ($booking->user_id !== auth()->id()) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $booking->delete();

    return response()->json(['message' => 'Booking deleted successfully'], 200);
}

}
