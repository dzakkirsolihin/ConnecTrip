<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TripSubmission;

class TripRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'first_name',
        'last_name',
        'address',
        'whatsapp',
        'emergency_contact',
        'medical_history',
        'instagram',
        'twitter',
        'privacy',
        'notes',
        'terms'
    ];

    protected $casts = [
        'terms' => 'boolean',
    ];

    // Relasi dengan trip submission
    public function trip()
    {
        return $this->belongsTo(TripSubmission::class, 'trip_id');
    }
}
