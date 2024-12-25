<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class destination extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'id_destination',
        'name_destination',
        'destination_description',
        'date',
        'address',
        'status_trip',
        'participant',
        'rundown',
        'social_media',
        'link_whatsapp',
    ];
}
