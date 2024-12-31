<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripSubmission;
use App\Models\User;

class TripSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample trip submissions
        $trips = [
            [
                'trip_name' => 'Mount Bromo Sunrise Trek',
                'description' => 'Experience the breathtaking sunrise at Mount Bromo with our expert guides. This trip includes transportation from Malang or Surabaya, camping equipment, and meals.',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(32),
                'meeting_point' => 'Malang Station, East Java',
                'whatsapp_group' => 'https://chat.whatsapp.com/sample1',
                'social_media' => '#BromoTrek #SunriseTrek #MountBromo',
                'price' => 1500000,
                'capacity' => 15,
                'payment_info' => "Bank Transfer:\nBCA: 1234567890\nMandiri: 0987654321\nPayment deadline: H-7 before trip",
                'is_public' => true,
                'notes' => 'Please bring warm clothes and comfortable hiking shoes',
                'terms' => true
            ],
            [
                'trip_name' => 'Bali Beach Hopping',
                'description' => 'Explore the most beautiful beaches in Bali in this 3-day adventure. Visit hidden gems and popular spots while enjoying local cuisine.',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(47),
                'meeting_point' => 'Ngurah Rai Airport, Bali',
                'whatsapp_group' => 'https://chat.whatsapp.com/sample2',
                'social_media' => '#BaliBeaches #BeachHopping #BaliTrip',
                'price' => 2000000,
                'capacity' => 10,
                'payment_info' => "Bank Transfer:\nBNI: 0123456789\nPayment deadline: H-10 before trip",
                'is_public' => true,
                'notes' => 'Snorkeling equipment will be provided',
                'terms' => true
            ],
            [
                'trip_name' => 'Yogyakarta Cultural Tour',
                'description' => 'Immerse yourself in Javanese culture with visits to Borobudur, Prambanan, and traditional craft villages.',
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(62),
                'meeting_point' => 'Yogyakarta International Airport',
                'whatsapp_group' => 'https://chat.whatsapp.com/sample3',
                'social_media' => '#YogyakartaTour #JavaCulture #Indonesia',
                'price' => 1750000,
                'capacity' => 12,
                'payment_info' => "Bank Transfer:\nBRI: 9876543210\nPayment deadline: H-14 before trip",
                'is_public' => true,
                'notes' => 'Traditional costume rental available for temple visits',
                'terms' => true
            ]
        ];

        foreach ($trips as $trip) {
            TripSubmission::create($trip);
        }
    }
}
