<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripRegistration;
use App\Models\TripSubmission;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test trip
        $trip = TripSubmission::create([
            'trip_name' => 'Test Trip to Bromo',
            'description' => 'A test trip for registration testing',
            'start_date' => now()->addDays(30),
            'end_date' => now()->addDays(32),
            'meeting_point' => 'Malang Station',
            'whatsapp_group' => 'https://chat.whatsapp.com/test',
            'social_media' => '#TestTrip',
            'price' => 1000000,
            'capacity' => 5,
            'payment_info' => 'BCA: 1234567890',
            'is_public' => true,
            'terms' => true
        ]);

        // Create a test registration
        TripRegistration::create([
            'trip_id' => $trip->id,
            'first_name' => 'Test',
            'last_name' => 'User',
            'address' => 'Test Address',
            'whatsapp' => '081234567890',
            'emergency_contact' => '087654321098',
            'medical_history' => null,
            'instagram' => '@testuser',
            'twitter' => '@testuser',
            'privacy' => 'public',
            'notes' => 'Test registration',
            'terms' => true
        ]);
    }
}
