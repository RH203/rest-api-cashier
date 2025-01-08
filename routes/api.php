<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\app\AuthController;

Route::get('/user', function (Request $request) {
    return response()->json([
        'message' => 'Hello World'
    ]);
});

/**
 * Auth route
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->middleware(['auth:sanctum', 'ability:superadmin']);


Route::middleware(['auth:sanctum', 'ability:superadmin,admin,cashier'])->group(function () {
  Route::get('/hallo', function () {
    return response()->json([
      'message' => 'Hello World'
    ]);
  });
});

