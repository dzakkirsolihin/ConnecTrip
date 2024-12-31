<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TripSubmission;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = TripSubmission::with('images')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($trip) {
                // Current time
                $now = Carbon::now();
                // Start date of the trip
                $startDate = Carbon::parse($trip->start_date);

                // Calculate days remaining and round up
                $trip->days_remaining = $now->diffInHours($startDate, false) > 0
                    ? ceil($now->diffInHours($startDate, false) / 24)
                    : 0;

                // Format dates
                $trip->formatted_start_date = $startDate->format('d F Y');
                $trip->formatted_end_date = Carbon::parse($trip->end_date)->format('d F Y');

                // Get random image from trip images
                $trip->random_image = $trip->images->count() > 0
                    ? $trip->images->random()->photo_path
                    : 'images/default-trip.jpg';

                return $trip;
            });

        return view('user.dashboard', compact('dashboard'));
    }
}