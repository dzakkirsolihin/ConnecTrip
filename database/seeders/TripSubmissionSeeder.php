<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TripSubmission;
use App\Models\TripImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TripSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::role('admin')->first();
        $users = User::role('user')->get();
        
        // Ensure the storage directories exist
        Storage::disk('public')->makeDirectory('trip-images');
        Storage::disk('public')->makeDirectory('ktp-uploads');

        // Copy sample images to storage
        $this->copySampleImages();

        $trips = [
            // Completed Trips (2023)
            [
                'trip_name' => 'Bali Beach Paradise',
                'description' => 'Experience the beauty of Bali\'s pristine beaches and vibrant culture.',
                'start_date' => '2023-03-15',
                'end_date' => '2023-03-20',
                'city' => 'Denpasar',
                'address' => 'Kuta Beach, Bali',
                'latitude' => -8.7184,
                'longitude' => 115.1686,
                'status' => 'approved'
            ],
            [
                'trip_name' => 'Mount Bromo Adventure',
                'description' => 'Witness the spectacular sunrise at Mount Bromo.',
                'start_date' => '2023-06-10',
                'end_date' => '2023-06-13',
                'city' => 'Malang',
                'address' => 'Mount Bromo, East Java',
                'latitude' => -7.9425,
                'longitude' => 112.9530,
                'status' => 'approved'
            ],

            // Ongoing Trips (Present)
            [
                'trip_name' => 'Lombok Island Expedition',
                'description' => 'Explore the pristine beaches and local culture of Lombok.',
                'start_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'city' => 'Mataram',
                'address' => 'Senggigi Beach, Lombok',
                'latitude' => -8.4913,
                'longitude' => 116.0329,
                'status' => 'approved'
            ],

            // Upcoming Trips
            [
                'trip_name' => 'Raja Ampat Diving',
                'description' => 'Discover the underwater paradise of Raja Ampat.',
                'start_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(35)->format('Y-m-d'),
                'city' => 'Sorong',
                'address' => 'Raja Ampat, West Papua',
                'latitude' => -0.5897,
                'longitude' => 130.1018,
                'status' => 'approved'
            ],
            [
                'trip_name' => 'Lake Toba Retreat',
                'description' => 'Experience the largest volcanic lake in the world.',
                'start_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(48)->format('Y-m-d'),
                'city' => 'Medan',
                'address' => 'Lake Toba, North Sumatra',
                'latitude' => 2.6736,
                'longitude' => 98.8675,
                'status' => 'approved'
            ],

            // Pending & Rejected Trips
            [
                'trip_name' => 'Yogyakarta Cultural Tour',
                'description' => 'Explore the rich cultural heritage of Yogyakarta.',
                'start_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(63)->format('Y-m-d'),
                'city' => 'Yogyakarta',
                'address' => 'Borobudur Temple, Magelang',
                'latitude' => -7.6079,
                'longitude' => 110.2038,
                'status' => 'pending'
            ],
            [
                'trip_name' => 'Komodo Dragon Adventure',
                'description' => 'Meet the famous Komodo dragons in their natural habitat.',
                'start_date' => Carbon::now()->addDays(75)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(78)->format('Y-m-d'),
                'city' => 'Labuan Bajo',
                'address' => 'Komodo National Park',
                'latitude' => -8.5449,
                'longitude' => 119.4889,
                'status' => 'rejected',
                'rejection_reason' => 'Insufficient safety measures outlined in the proposal.'
            ],
        ];

        foreach ($trips as $tripData) {
            $status = $tripData['status'];
            unset($tripData['status']);
            
            // Add common fields
            $tripData = array_merge($tripData, [
                'user_id' => $users->random()->id,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample',
                'social_media' => '@triporganizer',
                'price' => rand(1500000, 5000000),
                'capacity' => rand(10, 20),
                'notes' => 'Please bring your own equipment and supplies.',
                'terms' => true,
                'ktp_path' => 'ktp-uploads/sample-ktp.jpg',
            ]);

            $trip = TripSubmission::create($tripData);

            // Set status and review info if approved or rejected
            if ($status !== 'pending') {
                $trip->update([
                    'status' => $status,
                    'reviewed_at' => Carbon::now(),
                    'reviewed_by' => $admin->id,
                    'rejection_reason' => $tripData['rejection_reason'] ?? null,
                ]);
            }

            // Add trip images
            for ($i = 1; $i <= 3; $i++) {
                TripImage::create([
                    'trip_submission_id' => $trip->id,
                    'photo_path' => "trip-images/sample{$i}.jpg"
                ]);
            }
        }
    }

    private function copySampleImages(): void
    {
        // Sample KTP
        File::copy(
            public_path('images/sample-ktp.jpg'),
            storage_path('app/public/ktp-uploads/sample-ktp.jpg')
        );

        // Sample Trip Images
        for ($i = 1; $i <= 3; $i++) {
            File::copy(
                public_path("images/sample{$i}.jpg"),
                storage_path("app/public/trip-images/sample{$i}.jpg")
            );
        }
    }
}