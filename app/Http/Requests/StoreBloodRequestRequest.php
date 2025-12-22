<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBloodRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Any authenticated user (donor or recipient) can request blood
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'blood_type_needed' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'urgency'           => 'required|in:low,medium,high',
            'location_lat'      => 'required|numeric|between:-90,90',
            'location_lng'      => 'required|numeric|between:-180,180',
        ];
    }

    /**
     * Prepare the data for validation.
     * Automatically attach the logged-in user as recipient.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'recipient_id' => auth()->id(),
        ]);
    }
}
