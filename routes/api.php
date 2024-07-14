<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


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

Route::apiResource('user', UserController::class);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Defines all CRUD routes for the 'products' resource using Laravel's API resource routing.
});
Route::apiResource('products', ProductController::class); 
Route::put('/products/{id}', 'ProductController@update');

// Route to handle user registration (POST request)
Route::post('/register', [AuthController::class, 'register']);

// Route to handle user login (POST request)
Route::post('/login', [AuthController::class, 'login']);

// Route to handle user logout (POST request, requires authentication via Sanctum)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::apiResource('categories', CategoryController::class);
