<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoMemories extends Model
{
    use HasFactory;
    
    protected $table = 'photo_memories';
    
    protected $fillable = [
        'trip_submission_id',
        'photo_path'
    ];

    public function tripSubmission()
    {
        return $this->belongsTo(TripSubmission::class, 'trip_submission_id');
    }
}
