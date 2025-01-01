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
        'user_id',
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
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by'
    ];    

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'terms' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    // Scope untuk mendapatkan trip berdasarkan status
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Relasi dengan admin yang mereview
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    protected function getDurationAttribute(): int 
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        return $startDate->diffInDays($endDate) + 1;
    }

    public function registrations()
    {
        return $this->hasMany(TripRegistration::class, 'trip_id');
    }

    public function images()
    {
        return $this->hasMany(TripImage::class, 'trip_submission_id');
    }

    protected $appends = ['formatted_start_date', 'formatted_end_date'];

    public function photoMemories()
    {
        return $this->hasMany(PhotoMemories::class, 'trip_submission_id');
    }
}