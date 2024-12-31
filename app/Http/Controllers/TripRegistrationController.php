<?php

namespace App\Http\Controllers;

use App\Models\TripRegistration;
use App\Models\TripSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TripRegistrationController extends Controller
{
    public function create(TripSubmission $trip)
    {
        return view('user.destination', compact('trip'));
    }

    public function store(Request $request, TripSubmission $trip)
    {
        // Check if the user is already registered for this trip
        $existingRegistration = $trip->registrations()
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()->with('error', 'You are already registered for this trip.');
        }

        // Validate the form input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'whatsapp' => 'required|string',
            'emergency_contact' => 'required|string',
            'instagram' => 'required|string',
            'terms' => 'required|accepted',
        ]);

        // Check if the trip is full
        if ($trip->registrations()->count() >= $trip->capacity) {
            return redirect()->back()->with('error', 'Sorry, this trip is already full.');
        }

        // Create the registration
        $trip->registrations()->create([
            'user_id' => Auth::user()->id, // Assuming the user is logged in
            'full_name' => $validated['full_name'],
            'age' => $validated['age'],
            'whatsapp' => $validated['whatsapp'],
            'emergency_contact' => $validated['emergency_contact'],
            'instagram' => $validated['instagram'],
            'terms' => $validated['terms'],
        ]);

        return redirect()->route('destination.show', $trip->trip_name)
            ->with('success', 'You have successfully registered for this trip!');
    }

    public function confirmation(TripRegistration $registration)
    {
        return view('trips.confirmation', compact('registration'));
    }

    public function index(TripSubmission $trip)
    {
        $registrations = $trip->registrations()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('trips.registrations.index', compact('trip', 'registrations'));
    }
}