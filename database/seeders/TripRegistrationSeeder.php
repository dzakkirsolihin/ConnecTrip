<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripRegistration;
use App\Models\TripSubmission;

class TripRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first trip
        $trip = TripSubmission::first();

        if ($trip) {
            $registrations = [
                [
                    'trip_id' => $trip->id,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'address' => 'Jl. Sudirman No. 123, Jakarta',
                    'whatsapp' => '+6281234567890',
                    'emergency_contact' => '+6287654321098',
                    'medical_history' => 'No major medical conditions',
                    'instagram' => '@johndoe',
                    'twitter' => '@johndoe',
                    'privacy' => 'public',
                    'notes' => 'Vegetarian diet',
                    'terms' => true,
                ],
                [
                    'trip_id' => $trip->id,
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'address' => 'Jl. Thamrin No. 456, Jakarta',
                    'whatsapp' => '+6281234567891',
                    'emergency_contact' => '+6287654321099',
                    'medical_history' => 'Mild asthma',
                    'instagram' => '@janesmith',
                    'twitter' => '@janesmith',
                    'privacy' => 'private',
                    'notes' => 'Early riser',
                    'terms' => true,
                ],
            ];

            foreach ($registrations as $registration) {
                TripRegistration::create($registration);
            }
        }
    }
}
