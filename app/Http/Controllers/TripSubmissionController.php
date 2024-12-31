<?php

namespace App\Http\Controllers;

use App\Models\TripImage;
use App\Models\destination;
use Illuminate\Http\Request;
use App\Models\TripSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripSubmissionController extends Controller
{

    public function index()
    {
        $trips = TripSubmission::where('is_public', true)
            ->orderBy('start_date', 'asc')
            ->paginate(10);
        
        return view('trips.index', compact('trips'));
    }
    
    public function create()
    {
        return view('trips.submission');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'trip_name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'address' => 'required|string',
        'whatsapp_group' => 'required|url',
        'social_media' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:1',
        'notes' => 'nullable|string',
        'terms' => 'required|accepted',
        'images' => 'required|array|max:5', // Validasi maksimal 5 file
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg', // Validasi setiap file
    ], [
        'trip_name.required' => 'Trip name is required',
        'description.required' => 'Trip description is required',
        'start_date.required' => 'Start date is required',
        'end_date.after' => 'End date must be after start date',
        'whatsapp_group.url' => 'WhatsApp group link must be a valid URL',
        'price.min' => 'Price cannot be negative',
        'capacity.min' => 'Capacity must be at least 1 person',
        'terms.accepted' => 'You must accept the terms and conditions',
        'images.required' => 'At least one photo is required',
        'images.max' => 'You can upload up to 5 images only',
    ]);

    // Set default value for is_public if not provided
    $validated['is_public'] = $request->has('is_public') ? true : false;
    $validated['terms'] = $request->has('terms') ? true : false;

    DB::beginTransaction(); // Mulai transaksi database untuk memastikan konsistensi data

    try {
        // Simpan data ke tabel trip_submissions
        $trip = TripSubmission::create($validated);

        // Simpan data ke tabel photo_submissions
        foreach ($request->file('images') as $photo) {
            $photoPath = $photo->store('images_submissions', 'public'); // Simpan file di direktori storage/app/public/photos
            TripImage::create([
                'trip_submission_id' => $trip->id, // Foreign key
                'photo_path' => $photoPath, // Path file yang diupload
            ]);
        }

        DB::commit(); // Komit transaksi jika semua berhasil
        return redirect()
            ->route('trips.show', $trip)
            ->with('success', 'Trip and photos have been created successfully!');
    } catch (\Exception $e) {
        DB::rollBack(); // Batalkan transaksi jika terjadi error
        Log::error('Error during trip creation: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return back()
            ->withInput()
            ->with('error', 'Failed to create trip. Error: ' . $e->getMessage());
    }
}

    public function show(TripSubmission $trip)
    {
        $dashboard = TripSubmission::all(); // Mengambil semua data dari model Destination
        return view('user.dashboard', compact('dashboard'));
    }
}