<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TripImage;
use App\Models\TripSubmission;
use App\Models\TripRegistration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@connectrip'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'),
            ]
        );
        
        // Assign role 'user' to test user
        $user->assignRole('user');

        // Helper function to create a trip
        $createTrip = function($tripData) {
            $imagePath = $tripData['image_path'] ?? 'images/seeder-1.jpg';
            unset($tripData['image_path']); // Remove from trip data before creation
            
            $trip = TripSubmission::create($tripData);
            
            // Create trip image
            TripImage::create([
                'trip_submission_id' => $trip->id,
                'photo_path' => $imagePath
            ]);
            
            return $trip;
        };

        // Completed Trips (Past dates)
        $completedTrips = [
            [
                'trip_name' => 'Raja Ampat Adventure',
                'description' => 'Explore the beautiful islands of Raja Ampat',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->subMonths(3)->addDays(4),
                'city' => 'Raja Ampat',
                'address' => 'Raja Ampat, Papua Barat',
                'latitude' => -0.5897,
                'longitude' => 130.1018,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample1',
                'social_media' => '@rajaampat_trip',
                'price' => 5000000,
                'capacity' => 20,
                'notes' => 'Bring snorkeling gear',
                'terms' => true,
                'image_path' => 'images/seeder-1.jpg' // Menggunakan gambar seeder
            ],
            [
                'trip_name' => 'Mount Bromo Sunrise',
                'description' => 'Watch the spectacular sunrise at Mount Bromo',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->subMonths(2)->addDays(2),
                'city' => 'Malang',
                'address' => 'Mount Bromo, East Java',
                'latitude' => -7.9425,
                'longitude' => 112.9530,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample2',
                'social_media' => '@bromo_trip',
                'price' => 2500000,
                'capacity' => 15,
                'notes' => 'Warm clothing required',
                'terms' => true,
                'image_path' => 'images/seeder-2.jpg' // Menggunakan gambar seeder
            ],
        ];

        // Ongoing Trips (Current dates)
        $ongoingTrips = [
            [
                'trip_name' => 'Bali Cultural Tour',
                'description' => 'Experience Balinese culture and traditions',
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(3),
                'city' => 'Ubud',
                'address' => 'Ubud, Bali',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample3',
                'social_media' => '@bali_culture',
                'price' => 3000000,
                'capacity' => 25,
                'notes' => 'Traditional dress required for temple visits',
                'terms' => true,
                'image_path' => 'images/seeder-3.jpg' // Menggunakan gambar seeder
            ]
        ];

        // Upcoming Trips (Future dates)
        $upcomingTrips = [
            [
                'trip_name' => 'Komodo Island Explorer',
                'description' => 'Meet the mighty Komodo dragons',
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(1)->addDays(5),
                'city' => 'Labuan Bajo',
                'address' => 'Komodo National Park',
                'latitude' => -8.5449,
                'longitude' => 119.4989,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample4',
                'social_media' => '@komodo_trip',
                'price' => 6000000,
                'capacity' => 15,
                'notes' => 'Physical fitness required',
                'terms' => true,
                'image_path' => 'images/seeder-4.jpg' // Menggunakan gambar seeder
            ],
            [
                'trip_name' => 'Lake Toba Retreat',
                'description' => 'Relax at the worlds largest volcanic lake',
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(2)->addDays(3),
                'city' => 'Parapat',
                'address' => 'Lake Toba, North Sumatra',
                'latitude' => 2.6333,
                'longitude' => 98.8500,
                'whatsapp_group' => 'https://chat.whatsapp.com/sample5',
                'social_media' => '@toba_trip',
                'price' => 4000000,
                'capacity' => 20,
                'notes' => 'Cultural activities included',
                'terms' => true,
                'image_path' => 'images/seeder-5.jpg' // Menggunakan gambar seeder
            ]
        ];

        // Create trips and registrations
        foreach ($completedTrips as $tripData) {
            $trip = $createTrip($tripData);
            TripRegistration::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'full_name' => 'John Doe',
                'age' => 25,
                'whatsapp' => '081234567890',
                'emergency_contact' => '081234567891',
                'instagram' => '@johndoe_travel',
                'terms' => true
            ]);
        }

        foreach ($ongoingTrips as $tripData) {
            $trip = $createTrip($tripData);
            TripRegistration::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'full_name' => 'John Doe',
                'age' => 25,
                'whatsapp' => '081234567890',
                'emergency_contact' => '081234567891',
                'instagram' => '@johndoe_travel',
                'terms' => true
            ]);
        }

        foreach ($upcomingTrips as $tripData) {
            $trip = $createTrip($tripData);
            TripRegistration::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'full_name' => 'John Doe',
                'age' => 25,
                'whatsapp' => '081234567890',
                'emergency_contact' => '081234567891',
                'instagram' => '@johndoe_travel',
                'terms' => true
            ]);
        }
    }
}