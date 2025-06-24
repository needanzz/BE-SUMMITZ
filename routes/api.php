<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;    
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\MountainController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ScheduleController;
// use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah kamu bisa mendaftarkan rute API untuk aplikasimu. 
| Rute-rute ini akan dikelompokkan dalam grup middleware "api".
|
*/
// Route::get('/user', function (Request $request) {
// //     return 'Hello';
// // });

Route::middleware('api')->get('/ping', function () {
    return response()->json([
        'message' => 'API is working',
        'timestamp' => now(),
        'version' => '1.0'
    ]);
});

// ===== PUBLIC ROUTES (Tidak perlu authentication) =====
// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Public data yang bisa diakses tanpa login
Route::apiResource('provinces', ProvinceController::class);
Route::apiResource('mountains', MountainController::class);
Route::apiResource('trips', TripController::class);
Route::apiResource('itineraries', ItineraryController::class);
Route::apiResource('facilities', FacilityController::class);
Route::apiResource('galleries', GalleryController::class);
Route::apiResource('schedules', ScheduleController::class);
Route::post('/midtrans/callback', [PaymentController::class, 'midtransCallback']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user', fn(Request $request) => $request->user());
    Route::put('user/profile', [AuthController::class, 'updateProfile']);
    Route::post('user/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-admin', [AuthController::class, 'checkAdmin']);

    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::post('/payments/token', [PaymentController::class, 'createTransaction']);
    Route::post('/payments/store', [PaymentController::class, 'store']);
    
});

Route::middleware(['auth:sanctum', 'is_admin'])->apiResource('users', UserController::class);