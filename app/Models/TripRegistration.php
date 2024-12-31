<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TripSubmission;

class TripRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'full_name',
        'age',
        'whatsapp',
        'emergency_contact',
        'instagram',
        'terms'
    ];

    protected $casts = [
        'terms' => 'boolean',
        'age' => 'integer',
    ];

    public function trip()
    {
        return $this->belongsTo(TripSubmission::class, 'trip_id');
    }
}