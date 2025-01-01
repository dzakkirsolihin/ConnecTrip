<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripProposal;
use App\Models\User;
use Carbon\Carbon;

class TripProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            'Raja Ampat, Papua',
            'Mount Bromo, East Java',
            'Komodo Island, East Nusa Tenggara',
            'Lake Toba, North Sumatra',
            'Borobudur Temple, Central Java',
        ];

        $facilities = [
            'Transportation',
            'Accommodation',
            'Meals',
            'Tour Guide',
            'Insurance',
            'Documentation',
            'Welcome Dinner',
        ];

        foreach (range(1, 15) as $index) {
            $startDate = Carbon::now()->addDays(rand(10, 60));
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            
            TripProposal::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'destination' => $destinations[array_rand($destinations)],
                'title' => "Amazing Trip to " . $destinations[array_rand($destinations)],
                'description' => "Experience the beauty of Indonesia with our carefully planned trip. Enjoy scenic views, local cuisine, and unforgettable moments.",
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addDays(rand(3, 7)),
                'max_participants' => rand(5, 15),
                'price_per_person' => rand(1500000, 5000000),
                'meeting_point' => 'Airport Terminal ' . rand(1, 3),
                'whatsapp_group_link' => 'https://chat.whatsapp.com/example' . $index,
                'identity_number' => '33' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT) . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'status' => $status,
                'rejection_reason' => $status === 'rejected' ? 'Incomplete documentation provided' : null,
                'included_facilities' => array_slice($facilities, 0, rand(3, count($facilities))),
                'excluded_facilities' => array_slice($facilities, -rand(1, 3)),
                'important_notes' => "Please bring comfortable walking shoes and weather-appropriate clothing.",
            ]);
        }
    }
}
