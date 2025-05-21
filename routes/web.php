<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SeniorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscussionController as ControllersDiscussionController;
use App\Http\Controllers\Senior\DiscussionController;
use App\Http\Controllers\Senior\SeniorProgramController;
use App\Http\Controllers\SeniorProgramController as ControllersSeniorProgramController;
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
    Route::post('programs/{program}/mark-successful', [ProgramController::class, 'markSuccessful'])
    ->name('admin.programs.mark-successful');
    
    Route::resource('seniors', SeniorController::class)
    ->names('admin.seniors')
    ->except(['show']);

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
    ->except(['show'])
    ->names('admin.users');

    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('admin.reports.export.csv');

});







Route::middleware(['auth', 'verified', 'senior'])->group(function () {
    Route::get('/senior/dashboard', function () {
        return view('senior.dashboard');
    })->name('senior.dashboard');
    Route::get('/senior/programs', [ControllersSeniorProgramController::class, 'index'])->name('senior.programs.index');
    Route::get('/senior/programs/{program}', [ControllersSeniorProgramController::class, 'show'])->name('senior.programs.show');
    Route::post('/senior/programs/{program}/discussions', [ControllersDiscussionController::class, 'store'])->name('senior.programs.discussions.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');