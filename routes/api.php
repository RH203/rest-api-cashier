<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\app\AuthController;
use App\Http\Controllers\app\CashierController;

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
  Route::get('/category', [CashierController::class, 'getCategory']);
  Route::get('/menu', [CashierController::class, 'getMenu']);
});

