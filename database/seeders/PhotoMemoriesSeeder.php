<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\TripSubmission;
use App\Models\PhotoMemories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoMemoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the memories directory exists
        Storage::disk('public')->makeDirectory('memories');

        // Copy sample memory images
        $this->copySampleMemoryImages();

        // Get completed trips (end_date < now)
        $completedTrips = TripSubmission::where('status', 'approved')
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($completedTrips as $trip) {
            // Add 5-10 memories for each completed trip
            $memoriesCount = rand(5, 10);
            
            for ($i = 1; $i <= $memoriesCount; $i++) {
                PhotoMemories::create([
                    'trip_submission_id' => $trip->id,
                    'photo_path' => "memories/memory{$i}.jpg"
                ]);
            }
        }
    }

    private function copySampleMemoryImages(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            File::copy(
                public_path("images/memory{$i}.jpg"),
                storage_path("app/public/memories/memory{$i}.jpg")
            );
        }
    }
}