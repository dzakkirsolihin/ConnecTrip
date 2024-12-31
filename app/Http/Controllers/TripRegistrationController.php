<?php

namespace App\Http\Controllers;

use App\Models\TripRegistration;
use App\Models\TripSubmission;
use Illuminate\Http\Request;

class TripRegistrationController extends Controller
{
    public function create(TripSubmission $trip)
    {
        return view('trips.registration', compact('trip'));
    }

    public function store(Request $request, TripSubmission $trip)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'whatsapp' => 'required|string',
            'emergency_contact' => 'required|string',
            'medical_history' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'privacy' => 'required|in:public,private',
            'notes' => 'nullable|string',
            'terms' => 'required|accepted'
        ]);

        try {
            // Check if trip is still available
            if ($trip->registrations()->count() >= $trip->capacity) {
                return back()
                    ->withInput()
                    ->with('error', 'Sorry, this trip is already full.');
            }

            $registration = $trip->registrations()->create($validated);

            return redirect()
                ->route('registration.confirmation', $registration)
                ->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to register. Please try again.');
        }
    }

    public function confirmation(TripRegistration $registration)
    {
        return view('trips.confirmation', compact('registration'));
    }

    // Optional: untuk melihat daftar pendaftar (admin only)
    public function index(TripSubmission $trip)
    {
        $registrations = $trip->registrations()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('trips.registrations.index', compact('trip', 'registrations'));
    }
}