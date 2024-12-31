<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripSubmissionController;
use App\Http\Controllers\TripRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('user.dashboard');
})->name('dashboard');

Route::get('/trip-map', function () {
    return view('user.trip-map');
})->name('trip-map');

Route::get('/submission', function () {
    return view('user.trip-submission');
})->name('submission');

Route::get('/registration', function () {
    return view('user.trip-registration');
})->name('registration');

Route::get('/my-trip', function () {
    return view('user.my-trip');
})->name('my-trip');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trip Submission Routes
    Route::get('/trips/create', [TripSubmissionController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripSubmissionController::class, 'store'])->name('trip.store');
    Route::get('/trips/{trip}', [TripSubmissionController::class, 'show'])->name('trips.show');
    Route::get('/trips', [TripSubmissionController::class, 'index'])->name('trips.index');

    // Trip Registration Routes
    Route::get('/trips/{trip}/register', [TripRegistrationController::class, 'create'])->name('registration.create');
    Route::post('/trips/{trip}/register', [TripRegistrationController::class, 'store'])->name('registration.store');
    Route::get('/registration/{registration}/confirmation', [TripRegistrationController::class, 'confirmation'])->name('registration.confirmation');
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