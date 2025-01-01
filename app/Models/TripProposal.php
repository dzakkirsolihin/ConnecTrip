<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripProposal extends Model
{
    protected $fillable = [
        'user_id',
        'destination',
        'title',
        'description',
        'start_date',
        'end_date',
        'max_participants',
        'price_per_person',
        'meeting_point',
        'whatsapp_group_link',
        'identity_number', // KTP
        'status', // pending, approved, rejected
        'rejection_reason',
        'included_facilities',
        'excluded_facilities',
        'important_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'included_facilities' => 'array',
        'excluded_facilities' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
