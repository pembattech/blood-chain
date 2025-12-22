<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'recipient_id',
        'blood_type_needed',
        'urgency',
        'location_lat',
        'location_lng',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'location_lat' => 'decimal:8',
        'location_lng' => 'decimal:8',
    ];

    /**
     * Relationship: A blood request belongs to a recipient (user).
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
