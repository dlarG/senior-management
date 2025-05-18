<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SeniorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
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

Route::get('/login', [AuthController::class, 'loginview'])->name('login');
Route::get('/register', [AuthController::class, 'registerview']);
Route::post('/register', [AuthController::class, 'register'])->name('register_pro');
Route::post('/login', [AuthController::class, 'login'])->name('login_pro');


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

Route::post('/email/verify/resend', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.resend');







Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->name('admin.dashboard');

    Route::resource('programs', ProgramController::class)->names('admin.programs');
    Route::resource('seniors', SeniorController::class)
    ->names('admin.seniors')
    ->except(['show']);
});







Route::middleware(['auth', 'verified', 'senior'])->group(function () {
    Route::get('/senior/dashboard', function () {
        return view('senior.dashboard');
    })->name('senior.dashboard');
    Route::post('/programs/{program}/discussions', [\App\Http\Controllers\DiscussionController::class, 'store'])
        ->name('discussions.store');
    
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');