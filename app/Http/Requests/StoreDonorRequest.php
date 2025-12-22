<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_lat'      => 'required|numeric',
            'location_lng'      => 'required|numeric',
            'last_donation_date'=> 'nullable|date',
            'available'         => 'boolean',
            'health_condition'  => 'nullable|string',
        ];
    }
}
