<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PhotoMemories;
use App\Models\TripSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TripMapController extends Controller
{
    public function index()
    {
        // Get user's completed trips count
        $completedTripsCount = TripSubmission::where('user_id', Auth::id())
            ->where('end_date', '<', now())
            ->count();

        // Get total photos count for the user
        $totalPhotosCount = PhotoMemories::whereIn('trip_submission_id', function($query) {
            $query->select('id')
                  ->from('trip_submissions')
                  ->where('user_id', Auth::id());
        })->count();

        // Get all user's trips with necessary relations and data
        $trips = TripSubmission::where('user_id', Auth::id())
            ->where('end_date', '<', now())  // Only completed trips
            ->with(['images', 'photoMemories'])
            ->get()
            ->map(function ($trip) {
                return [
                    'id' => $trip->id,
                    'name' => $trip->trip_name,
                    'year' => Carbon::parse($trip->start_date)->year,
                    'start_date' => $trip->start_date,
                    'end_date' => $trip->end_date,
                    'latitude' => $trip->latitude,
                    'longitude' => $trip->longitude,
                    'image' => $trip->images->first() ? 
                        Storage::url($trip->images->first()->photo_path) : 
                        asset('images/default.jpg'),
                    'city' => $trip->city,
                    'location' => $trip->address,
                    'description' => $trip->description,
                    'price' => $trip->price,
                    'capacity' => $trip->capacity,
                    'total_photos' => $trip->photoMemories->count()
                ];
            });

        // Get unique years for the filter
        $years = $trips->pluck('year')->unique()->sort()->values();

        return view('user.trip-map', compact(
            'completedTripsCount',
            'totalPhotosCount',
            'trips',
            'years'
        ));
    }

    public function uploadPhotos(Request $request)
    {
        try {
            $request->validate([
                'photos.*' => 'required|image|max:5120', // 5MB max
                'trip_submission_id' => 'required|exists:trip_submissions,id'
            ]);

            // Verify trip belongs to user
            $trip = TripSubmission::findOrFail($request->trip_submission_id);
            if ($trip->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized');
            }

            $uploadedPhotos = [];

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('memories', 'public');
                    
                    $photoMemory = PhotoMemories::create([
                        'trip_submission_id' => $request->trip_submission_id,
                        'photo_path' => $path
                    ]);

                    $uploadedPhotos[] = [
                        'id' => $photoMemory->id,
                        'url' => Storage::url($path)
                    ];
                }
            }

            return response()->json($uploadedPhotos);
        } catch (\Exception $e) {
            Log::error('Photo upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPhotos($tripId)
    {
        try {
            // Verify trip belongs to user
            $trip = TripSubmission::with(['images', 'photoMemories'])
                ->where('user_id', Auth::id())
                ->findOrFail($tripId);

            $photos = $trip->photoMemories->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'url' => Storage::url($photo->photo_path)
                ];
            });

            $tripDetails = [
                'trip_name' => $trip->trip_name,
                'city' => $trip->city,
                'address' => $trip->address,
                'start_date' => $trip->start_date,
                'end_date' => $trip->end_date,
                'description' => $trip->description,
                'price' => $trip->price,
                'capacity' => $trip->capacity,
                'cover_image' => $trip->images->first() ? 
                    Storage::url($trip->images->first()->photo_path) : 
                    asset('images/default.jpg'),
                'photos' => $photos
            ];

            return response()->json($tripDetails);
        } catch (\Exception $e) {
            Log::error('Get photos error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePhoto($id)
    {
        try {
            $photo = PhotoMemories::findOrFail($id);
            
            // Check if user owns the photo through trip ownership
            $trip = TripSubmission::findOrFail($photo->trip_submission_id);
            if ($trip->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized');
            }
            
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Delete photo error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}