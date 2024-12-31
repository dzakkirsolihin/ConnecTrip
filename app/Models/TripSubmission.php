<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripSubmission extends Model
{
    use HasFactory;

    protected $table = 'trip_submissions';

    protected $fillable = [
        'trip_name',
        'description',
        'start_date',
        'end_date',
        'city',
        'address',
        'latitude',
        'longitude',
        'ktp_path',
        'whatsapp_group',
        'social_media',
        'price',
        'capacity',
        'notes',
        'terms',
    ];    

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'terms' => 'boolean',
    ];

    protected function getDurationAttribute(): int 
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        
        // return $endDate->diffInDays($startDate) + 1;
        // atau bisa juga ditulis:
        return $startDate->diffInDays($endDate) + 1;
    }

    // Relasi dengan registrations
    public function registrations()
    {
        return $this->hasMany(TripRegistration::class, 'trip_id'); // Use 'trip_id' as the foreign key
    }

    public function images()
    {
        return $this->hasMany(TripImage::class, 'trip_submission_id');
    }
}
