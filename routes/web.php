<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripSubmissionController;
use App\Http\Controllers\TripRegistrationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripMapController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MyTripController;
use App\Http\Middleware\CheckRole;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Middleware to enforce authentication for all routes except the dashboard
Route::middleware('auth')->group(function () {
    // Guest-accessible routes (require login to access)
    Route::view('/trip-map', 'user.trip-map')->name('trip-map');
    // Route::view('/submission', 'user.trip-submission')->name('submission');
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
        Route::get('/trips/submit', 'index')->name('trip-submission');
        Route::post('/trips/store', 'store')->name('trip.store');
        Route::get('/trips/{trip}', 'show')->name('trips.show');
        // Route::get('/trips', 'user.trip-submission')->name('trips.index');
    });

    // Trip registration routes
    Route::controller(TripRegistrationController::class)->group(function () {
        Route::get('/trips/{trip}/register', 'create')->name('registration.create');
        Route::post('/trips/{trip}/register', 'store')->name('registration.store');
        Route::get('/registration/{registration}/confirmation', 'confirmation')->name('registration.confirmation');
    });

    // Trip Map Routes
    Route::controller(TripMapController::class)->group(function () {
        Route::get('/map', 'index')->name('trip-map');
    });

    Route::controller(MyTripController::class)->group(function () {
        Route::get('/my-trip', 'index')->name('my-trip');
    });

    // Destination page route (requires login)
    Route::get('/destination/{trip:trip_name}', [TripSubmissionController::class, 'show'])
        ->name('destination.show');

    // Memories/photo routes
    Route::prefix('memories')->group(function () {
        Route::post('/upload', [TripMapController::class, 'uploadPhotos'])->name('memories.upload');
        Route::get('/{destinationId}', [TripMapController::class, 'getPhotos'])->name('memories.get');
        Route::delete('/{id}', [TripMapController::class, 'deletePhoto'])->name('memories.delete');
    });
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/trips/{tripSubmission}', [AdminController::class, 'showTripDetails'])->name('admin.trips.show');
        Route::patch('/trips/{tripSubmission}/status', [AdminController::class, 'updateTripStatus'])->name('admin.trips.update-status');
        Route::get('/trips/{tripSubmission}/details', [AdminController::class, 'getTripDetails'])->name('admin.trips.details');
    });
});

require __DIR__.'/auth.php';