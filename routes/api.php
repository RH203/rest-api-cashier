<?php

use App\Http\Controllers\app\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\app\CashierController;
use App\Http\Controllers\app\AdminController;


/**
 * Auth route
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->middleware(['auth:sanctum', 'ability:superadmin']);


/**
 * Admin route
 */
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
  /**
   * User
   */
  Route::get('/get-user', [AdminController::class, 'showCashier']);
  Route::post('/update-user', [AdminController::class, 'updateCashier']);
  Route::post('/delete-user', [AdminController::class, 'deleteCashier']);
  /**
   * Product
   */
  Route::post('/add-product', [AdminController::class, 'createProduct']);
  Route::post('/update-product', [AdminController::class, 'updateProduct']);
  Route::post('/delete-product', [AdminController::class, 'deleteProduct']);
});

/**
 * Cashier route
 */
Route::middleware(['web', 'auth:sanctum', 'ability:cashier,admin'])->group(function () {
  Route::get('/category', [CashierController::class, 'getCategory']);
  Route::get('/menu', [CashierController::class, 'getMenu']);
  Route::get('/logout', [AuthController::class, 'logout']);
  Route::get('/show-table', [CashierController::class, 'showTable']);
  Route::post('/create-reservation', [CashierController::class, 'createReservation']);
  Route::post('/create-order', [CashierController::class, 'createOrder']);
});
