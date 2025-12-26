<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class matches extends Model
{
    protected $fillable = [
        'blood_request_id',
        'donor_id',
        'status'
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

}
