<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TripRegistration;
use Illuminate\Support\Facades\Auth;

class MyTripController extends Controller
{
    public function index()
    {
        // Mendapatkan tanggal saat ini
        $currentDate = Carbon::now();
        
        // Mengambil semua registrasi trip user yang login
        $userRegistrations = TripRegistration::where('user_id', Auth::id())
            ->with(['trip' => function($query) {
                $query->with(['images' => function($query) {
                    $query->inRandomOrder()->limit(1);
                }]);
            }])
            ->get();

        // Memisahkan trip berdasarkan status
        $tripsData = [
            'completed' => $userRegistrations->filter(function($registration) use ($currentDate) {
                return Carbon::parse($registration->trip->end_date)->lt($currentDate);
            })->map(function($registration) {
                return $this->formatTripData($registration);
            }),
            
            'ongoing' => $userRegistrations->filter(function($registration) use ($currentDate) {
                $startDate = Carbon::parse($registration->trip->start_date);
                $endDate = Carbon::parse($registration->trip->end_date);
                return $currentDate->between($startDate, $endDate);
            })->map(function($registration) {
                return $this->formatTripData($registration);
            }),
            
            'upcoming' => $userRegistrations->filter(function($registration) use ($currentDate) {
                return Carbon::parse($registration->trip->start_date)->gt($currentDate);
            })->map(function($registration) {
                return $this->formatTripData($registration);
            })
        ];

        return view('user.my-trip', compact('tripsData'));
    }

    private function formatTripData($registration)
    {
        return [
            'id' => $registration->trip->id,
            'image_url' => $registration->trip->images->first() 
                ? asset('storage/' . $registration->trip->images->first()->photo_path)
                : asset('images/default-trip.jpg'),
            'name' => $registration->trip->trip_name,
            'start_date' => Carbon::parse($registration->trip->start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($registration->trip->end_date)->format('d-m-Y'),
            'location' => $registration->trip->city,
            'price' => number_format($registration->trip->price, 0, ',', '.'),
            'full_name' => $registration->full_name,
            'social_media' => $registration->instagram
        ];
    }
}