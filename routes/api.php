<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController; // Import AuthController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Existing /user route, typically for authenticated users via Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route for user login using the AuthController
Route::post('/login', [AuthController::class, 'login']);

// Group of routes that require authentication using 'auth:sanctum' middleware
// This is typical for JWT or Sanctum-protected routes after login
Route::middleware('auth:sanctum')->group(function () {
    // Route for user logout using the AuthController
    Route::post('/logout', [AuthController::class, 'logout']);
});

