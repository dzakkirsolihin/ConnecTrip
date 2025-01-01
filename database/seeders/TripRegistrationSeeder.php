<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TripSubmission;
use App\Models\TripRegistration;
use Illuminate\Database\Seeder;

class TripRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('user')->get();
        $approvedTrips = TripSubmission::where('status', 'approved')->get();

        foreach ($approvedTrips as $trip) {
            // Register 1-3 users for each approved trip (karena kita hanya punya 3 user)
            $registrationCount = min(rand(1, 3), $users->count());
            $registeredUsers = $users->random($registrationCount);

            foreach ($registeredUsers as $user) {
                TripRegistration::create([
                    'trip_id' => $trip->id,
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'age' => rand(20, 40),
                    'whatsapp' => '08' . rand(1000000000, 9999999999),
                    'emergency_contact' => '08' . rand(1000000000, 9999999999),
                    'instagram' => '@' . strtolower(str_replace(' ', '', $user->name)),
                    'terms' => true,
                ]);
            }
        }
    }
}