<?php

namespace App\Models;

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
        'address',
        'whatsapp_group',
        'social_media',
        'price',
        'capacity',
        'notes',
        'terms'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'terms' => 'boolean',
    ];

    // Relasi dengan registrations
    public function registrations()
    {
        return $this->hasMany(TripRegistration::class);
    }

    public function images()
    {
        return $this->hasMany(TripImage::class);
    }
}
