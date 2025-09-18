<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    /** @use HasFactory<\Database\Factories\DonorFactory> */
    use HasFactory;

    protected $fillable = [
        "user_id",
        "blood_type",
        "location_lat",
        "location_lng",
        "last_donation_date",
        "available",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
