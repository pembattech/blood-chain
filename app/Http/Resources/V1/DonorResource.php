<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'blood_type' => $this->blood_type,
            'location' => [
                'lat' => $this->location_lat,
                'lng' => $this->location_lng,
            ],
            'last_donation_date' => $this->last_donation_date,
            'available' => $this->available,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
