<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Http\Resources\V1\DonorResource;
use App\Models\Donor;

class DonorController extends Controller
{
    // List donors
    public function index()
    {
        // TODO: Implement filtering by blood type and availability
        return DonorResource::collection(Donor::with('user')->paginate(10));
    }

    // Show single donor
    public function show(Donor $donor)
    {
        return new DonorResource($donor->load('user'));
    }

    // Store new donor
    public function store(StoreDonorRequest $request)
    {
        $donor = Donor::create([
            'user_id' => $request->user()->id,
            ...$request->validated(),
        ]);

        return new DonorResource($donor);
    }

    // Update donor
    public function update(UpdateDonorRequest $request, Donor $donor)
    {
        $donor->update($request->validated());

        return new DonorResource($donor);
    }

    // Delete donor
    public function destroy(Donor $donor)
    {
        $donor->delete();

        return response()->json(['message' => 'Donor deleted successfully.']);
    }
}
