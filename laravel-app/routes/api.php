<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BikeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login Route
Route::post('auth/login', [AuthController::class, 'login']);

// API protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('bike/{id}', [BikeController::class, 'show']);
    Route::get('bikes', [BikeController::class, 'search']);
    Route::post('bikes', [BikeController::class, 'store']);
});

