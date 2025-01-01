<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TripImage;
use App\Models\TripSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan Auth untuk user login
use Illuminate\Support\Facades\Log;

class TripSubmissionController extends Controller
{
    public function index()
    {
        $trips = TripSubmission::orderBy('start_date', 'asc')
            ->with('images')
            ->paginate(10);

        return view('trips.index', compact('trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'ktp' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'whatsapp_group' => 'required|url',
            'social_media' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            DB::beginTransaction();

            // Upload KTP
            $ktpPath = $request->file('ktp')->store('ktp-uploads', 'public');

            // Dapatkan Latitude dan Longitude dari Alamat
            $geoData = $this->getCoordinatesFromAddress($validated['address']);

            // Buat entri TripSubmission
            $trip = TripSubmission::create([
                'trip_name' => $validated['trip_name'],
                'description' => $validated['description'],
                'start_date' => Carbon::parse($validated['start_date'])->format('Y-m-d'),
                'end_date' => Carbon::parse($validated['end_date'])->format('Y-m-d'),
                'city' => $validated['city'],
                'address' => $validated['address'],
                'latitude' => $geoData['latitude'],
                'longitude' => $geoData['longitude'],
                'ktp_path' => $ktpPath,
                'whatsapp_group' => $validated['whatsapp_group'],
                'social_media' => $validated['social_media'],
                'price' => $validated['price'],
                'capacity' => $validated['capacity'],
                'notes' => $validated['notes'],
                'terms' => true,
            ]);

            // Upload Gambar Trip ke Tabel trip_images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('trip-images', 'public'); // Disimpan di storage/app/public/trip-images/
                    TripImage::create([
                        'trip_submission_id' => $trip->id,
                        'photo_path' => $path // Akan tersimpan sebagai 'trip-images/nama_file.jpg'
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Trip submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Trip submission error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to submit trip. Please try again.']);
        }
    }

    private function getCoordinatesFromAddress($address)
    {
        try {
            // Gunakan Google Maps API atau layanan geocoding lainnya
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data['results'])) {
                return [
                    'latitude' => $data['results'][0]['geometry']['location']['lat'],
                    'longitude' => $data['results'][0]['geometry']['location']['lng'],
                ];
            }

            return ['latitude' => null, 'longitude' => null];
        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return ['latitude' => null, 'longitude' => null];
        }
    }

    public function show($tripName)
    {
        // Ambil detail trip dengan relasi images dan registrations
        $trip = TripSubmission::with('images', 'registrations')
            ->where('trip_name', $tripName)
            ->firstOrFail();

        $trip->image_url = $trip->images->first() 
            ? (str_starts_with($trip->images->first()->photo_path, 'images/') 
                ? asset($trip->images->first()->photo_path)
                : asset('storage/' . $trip->images->first()->photo_path))
            : asset('images/Opening.png');

        // Tambahkan logika untuk memeriksa apakah user telah mendaftar ke trip
        $userRegistered = $trip->registrations->contains('user_id', Auth::id());

        return view('user.destination', [
            'tripsubmissions' => $trip,
            'userRegistered' => $userRegistered, // Pass status pendaftaran ke Blade
        ]);
    }
}