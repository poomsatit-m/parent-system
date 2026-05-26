<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\pkruDataController as pkruData;
use GuzzleHttp\Middleware;

Route::get('/', function () {
    return view('auth.login');
});
Route::post('login-pkru', [Login::class, 'login'])->name('login.pkru');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('select-student', [ProfileController::class, 'selectStudent'])->name('select-student');
    Route::get('student/{studentId}', [ProfileController::class, 'studentProfile'])->name('profile.student');


    Route::middleware(['checkStudent'])
        ->prefix('students')
        ->name('students.')
        ->group(function () {
            Route::get('/', [pkruData::class, 'studentDashboard'])->name('dashboard');


        });
});

require __DIR__ . '/auth.php';
