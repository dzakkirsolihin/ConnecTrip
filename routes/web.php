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

    // // Trip related routes (requires authentication)
    // Route::prefix('trips')->group(function () {
    //     // Trip proposal route
    //     Route::get('/propose', function () {
    //         return view('user.propose-trip');
    //     })->name('trips.propose');

    //     // Trip registration route
    //     Route::get('/{trip}/register', function () {
    //         return view('user.trip-registration');
    //     })->name('trips.register');
    // });

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
        Route::patch('/proposals/{proposal}/update-status', [AdminController::class, 'updateStatus'])->name('admin.proposals.update-status');
    });
});

require __DIR__.'/auth.php';

// Contoh Grouping Route dengan Middleware
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
// });

// // Contoh Grouping Route denga Prefix
// Route::prefix('user')->group(function () {
//     Route::get('/', [DashboardController::class, 'index'])->name('user.dashboard');
// });

// Contoh Grouping dengan Route Name Prefix
// Route::name('admin.')->prefix('admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
// });

// Contoh Grouping dengan subdomain
// Route::domain('{account}.example.com')->group(function () {
//     Route::get('/dashboard', [AccountDashboardController::class, 'index'])->name('account.dashboard');
//     Route::get('/settings', [AccountSettingController::class, 'index'])->name('account.settings');
// });
