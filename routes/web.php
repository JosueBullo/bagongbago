<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerPanelController;
use App\Http\Controllers\CustomerProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//auth
Route::middleware('auth')->group(function () {
});
Route::get('/register', function () {
    return view('auth.register'); // Renders resources/views/register.blade.php
});
Route::get('/login', function () {
    return view('auth.login'); // Renders resources/views/login.blade.php
});

//productmanagement
Route::get('/products', function () {
    return view('products'); // Renders resources/views/login.blade.php
});

//adminindex
Route::get('/admin', function () {
    return view('adminindex');
});

//users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


//category management
Route::get('/category', function() {
    return view('categories.categoryindex');
});




Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/customer', [CustomerPanelController::class, 'index'])->name('customerpanel');

Route::get('/cusprod', [CustomerProductController::class, 'index'])->name('cusproducts');



