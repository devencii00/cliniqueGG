<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin', function () {
        return view('dashview.admin');
    })->name('admin.dashboard')->middleware('can:admin');

    Route::get('/patient', function () {
        return view('dashview.patient');
    })->name('patient.dashboard');

    // Queue JSON endpoints (session-based for dashboard use)
    Route::get('/queue/my', [QueueController::class, 'myQueue']);
    Route::post('/queue/join', [QueueController::class, 'joinQueue']);
    Route::post('/queue/leave', [QueueController::class, 'leaveQueue']);
    Route::get('/queue/list', [QueueController::class, 'queueList']);
    Route::post('/queue/call-next', [QueueController::class, 'callNext']);
    Route::post('/queue/{id}/complete', [QueueController::class, 'completeQueue']);
});

// Public queue display — no auth
Route::get('/queue/display', function () {
    return view('dashview.public-queue');
})->name('public.queue');
