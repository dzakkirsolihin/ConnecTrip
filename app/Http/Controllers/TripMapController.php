<?php

namespace App\Http\Controllers;

use App\Models\PhotoMemories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TripMapController extends Controller
{
    public function index()
    {
        return view('user.trip-map');
    }

    public function uploadPhotos(Request $request)
    {
        try {
            $request->validate([
                'photos.*' => 'required|image|max:5120', // 5MB max
                'destination_id' => 'required'
            ]);

            $uploadedPhotos = [];

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('memories', 'public');
                    
                    $photoMemory = PhotoMemories::create([
                        'destination_id' => $request->destination_id,
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

    public function getPhotos($destinationId)
    {
        try {
            $photos = PhotoMemories::where('destination_id', $destinationId)
                ->get()
                ->map(function ($photo) {
                    return [
                        'id' => $photo->id,
                        'url' => Storage::url($photo->photo_path)
                    ];
                });

            return response()->json($photos);
        } catch (\Exception $e) {
            Log::error('Get photos error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePhoto($id)
    {
        $photo = PhotoMemories::findOrFail($id);
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return response()->json(['success' => true]);
    }
}