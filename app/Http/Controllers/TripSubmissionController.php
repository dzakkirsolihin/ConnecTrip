<?php

namespace App\Http\Controllers;

use App\Models\TripSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TripSubmissionController extends Controller
{
    public function create()
    {
        return view('trips.submission');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'meeting_point' => 'required|string',
            'whatsapp_group' => 'required|url',
            'social_media' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'payment_info' => 'required|string',
            'is_public' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'terms' => 'required|accepted'
        ], [
            'trip_name.required' => 'Trip name is required',
            'description.required' => 'Trip description is required',
            'start_date.required' => 'Start date is required',
            'end_date.after' => 'End date must be after start date',
            'whatsapp_group.url' => 'WhatsApp group link must be a valid URL',
            'price.min' => 'Price cannot be negative',
            'capacity.min' => 'Capacity must be at least 1 person',
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        // Debug input yang diterima
        Log::info('Trip submission input:', $request->all());

        // Set default value for is_public if not provided
        $validated['is_public'] = $request->has('is_public') ? true : false;
        $validated['terms'] = $request->has('terms') ? true : false;

        // Debug data yang telah divalidasi
        Log::info('Validated data:', $validated);

        try {
            $trip = TripSubmission::create($validated);
            
            // Debug trip yang dibuat
            Log::info('Created trip:', $trip->toArray());

            return redirect()
                ->route('trips.show', $trip)
                ->with('success', 'Trip has been created successfully!');
        } catch (\Exception $e) {
            Log::error('Trip creation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create trip. Error: ' . $e->getMessage());
        }
    }

    public function show(TripSubmission $trip)
    {
        return view('trips.show', compact('trip'));
    }

    public function index()
    {
        $trips = TripSubmission::where('is_public', true)
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('trips.index', compact('trips'));
    }
}