<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_submission_id',
        'photo_path',
    ];

    public function tripSubmission()
    {
        return $this->belongsTo(TripSubmission::class, 'trip_submission_id');
    }
}
