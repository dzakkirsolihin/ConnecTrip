<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripImage extends Model
{
    protected $fillable = ['photo_path', 'trip_submission_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
