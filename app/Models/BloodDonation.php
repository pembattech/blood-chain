<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodDonation extends Model
{
    protected $fillable = [
        'donor_id',
        'blood_request_id',
        'location',
        'units',
        'date',
        'status'
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function request()
    {
        return $this->belongsTo(BloodRequest::class, 'blood_request_id');
    }
}
