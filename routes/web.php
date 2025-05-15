<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginview']);
Route::get('/register', [AuthController::class, 'registerview']);
Route::post('/register', [AuthController::class, 'register'])->name('register_pro');
Route::post('/login', [AuthController::class, 'login'])->name('login_pro');
