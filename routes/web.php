<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripSubmissionController;
use App\Http\Controllers\TripRegistrationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Middleware to enforce authentication for all routes except the dashboard
Route::middleware('auth')->group(function () {
    // Guest-accessible routes (require login to access)
    Route::view('/trip-map', 'user.trip-map')->name('trip-map');
    Route::view('/submission', 'user.trip-submission')->name('submission');
    Route::view('/registration', 'user.trip-registration')->name('registration');
    Route::view('/my-trip', 'user.my-trip')->name('my-trip');

    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Trip submission routes
    Route::controller(TripSubmissionController::class)->group(function () {
        Route::get('/trips/create', 'create')->name('trips.create');
        Route::post('/trips', 'store')->name('trip.store');
        Route::get('/trips/{trip}', 'show')->name('trips.show');
        Route::get('/trips', 'index')->name('trips.index');
    });

    // Trip registration routes
    Route::controller(TripRegistrationController::class)->group(function () {
        Route::get('/trips/{trip}/register', 'create')->name('registration.create');
        Route::post('/trips/{trip}/register', 'store')->name('registration.store');
        Route::get('/registration/{registration}/confirmation', 'confirmation')->name('registration.confirmation');
    });

    // Destination page route (requires login)
    Route::get('/destination/{trip:trip_name}', [TripSubmissionController::class, 'show'])
        ->name('destination.show');
});

// Role-based routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('/user', 'user.dashboard')->name('user.dashboard');
});

// Authentication routes
require __DIR__.'/auth.php';
