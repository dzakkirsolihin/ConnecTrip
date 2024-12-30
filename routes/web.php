<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripMapController;


Route::get('/', function () {
    return view('user.dashboard');
})->name('dashboard');

Route::get('/trip-map', function () {
    return view('user.trip-map');
})->middleware(['auth', 'verified'])->name('trip-map');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/memories/upload', [TripMapController::class, 'uploadPhotos'])->name('memories.upload');
    Route::get('/memories/{destinationId}', [TripMapController::class, 'getPhotos'])->name('memories.get');
    Route::delete('/memories/{id}', [TripMapController::class, 'deletePhoto'])->name('memories.delete');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
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