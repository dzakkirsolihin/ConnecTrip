<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
