<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TripSubmission;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $status = $request->get('status', 'pending');
        
        $submissions = TripSubmission::with(['images', 'reviewer'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        $counts = [
            'all' => TripSubmission::count(),
            'pending' => TripSubmission::where('status', 'pending')->count(),
            'approved' => TripSubmission::where('status', 'approved')->count(),
            'rejected' => TripSubmission::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard-admin', compact('submissions', 'counts', 'status'));
    }

    public function updateTripStatus(Request $request, TripSubmission $tripSubmission)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);

        $tripSubmission->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
            'reviewed_at' => Carbon::now(),
            'reviewed_by' => Auth::id(),
        ]);

        // Kirim notifikasi ke user (bisa diimplementasikan nanti)

        return back()->with('success', 'Trip status has been updated successfully.');
    }

    public function showTripDetails(TripSubmission $tripSubmission): View
    {
        return view('admin.trip-details', compact('tripSubmission'));
    }

    public function getTripDetails(TripSubmission $tripSubmission)
    {
        // Eager load the images relationship
        $tripSubmission->load(['images', 'reviewer']);
        
        // Format data untuk frontend
        $formattedTrip = [
            'trip_name' => $tripSubmission->trip_name,
            'city' => $tripSubmission->city,
            'address' => $tripSubmission->address, // Pastikan field ini ada di model
            'start_date' => $tripSubmission->start_date->format('Y-m-d'),
            'end_date' => $tripSubmission->end_date->format('Y-m-d'),
            'duration' => $tripSubmission->duration,
            'price' => $tripSubmission->price,
            'capacity' => $tripSubmission->capacity,
            'status' => $tripSubmission->status,
            'description' => $tripSubmission->description,
            'whatsapp_group' => $tripSubmission->whatsapp_group, // Pastikan field ini ada di model
            'social_media' => $tripSubmission->social_media, // Pastikan field ini ada di model
            'notes' => $tripSubmission->notes, // Pastikan field ini ada di model
            'ktp_path' => $tripSubmission->ktp_path, // Pastikan field ini ada di model
            'images' => $tripSubmission->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'photo_path' => $image->photo_path
                ];
            })
        ];
        
        return response()->json($formattedTrip);
    }
}