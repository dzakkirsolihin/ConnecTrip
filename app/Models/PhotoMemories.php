<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoMemories extends Model
{
    protected $table = 'photo_memories';
    protected $fillable = ['destination_id', 'photo_path'];
}
