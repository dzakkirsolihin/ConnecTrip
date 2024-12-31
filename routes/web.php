<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripMapController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckRole;

// Public routes (accessible to everyone)
Route::get('/', function () {
    return view('user.dashboard');
})->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/proposals/{proposal}/update-status', [AdminController::class, 'updateStatus'])->name('admin.proposals.update-status');
    });
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trip related routes (requires authentication)
    Route::prefix('trips')->group(function () {
        // Trip map route
        Route::get('/map', function () {
            return view('user.trip-map');
        })->name('trip-map');

        // My trips route
        Route::get('/my-trips', function () {
            return view('user.my-trips');
        })->name('my-trips');

        // Trip proposal route
        Route::get('/propose', function () {
            return view('user.propose-trip');
        })->name('trips.propose');

        // Trip registration route
        Route::get('/{trip}/register', function () {
            return view('user.trip-registration');
        })->name('trips.register');
    });

    // Memories/photo routes
    Route::prefix('memories')->group(function () {
        Route::post('/upload', [TripMapController::class, 'uploadPhotos'])->name('memories.upload');
        Route::get('/{destinationId}', [TripMapController::class, 'getPhotos'])->name('memories.get');
        Route::delete('/{id}', [TripMapController::class, 'deletePhoto'])->name('memories.delete');
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