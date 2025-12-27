<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function createDonation(Request $request)
    {
        $user = $request->user();

        // Ensure user is a donor
        if (!$user->donor) {
            return response()->json([
                'success' => false,
                'message' => 'You are not registered as a donor.'
            ], 403);
        }

        $donor = $user->donor;

        // Check for existing pending donation
        $existing = BloodDonation::where('donor_id', $donor->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending donation.'
            ], 409);
        }

        // Check last donation date
        $lastDonation = BloodDonation::where('donor_id', $donor->id)
            ->where('status', 'completed')
            ->latest('date')
            ->first();

        if ($lastDonation) {
            $nextEligibleDate = Carbon::parse($lastDonation->date)->addWeeks(12);

            if (Carbon::now()->lt($nextEligibleDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not eligible to donate yet.',
                    'next_eligible_date' => $nextEligibleDate->toDateString()
                ], 422);
            }
        }

        // Create new donation
        $donation = BloodDonation::create([
            'donor_id' => $donor->id,
            'blood_request_id' => $request->blood_request_id ?? null,
            'location' => $request->location ?? 'Default Hospital',
            'units' => $request->units ?? 0.5,
            'date' => Carbon::now()->toDateString(),
            'status' => 'completed',
        ]);

        // Update donor availability and last donation date
        $donor->update([
            'available' => false,
            'last_donation_date' => Carbon::now()->toDateString()
        ]);

        // Update blood request status to 'fulfilled' if applicable
        if ($request->blood_request_id) {
            $bloodRequest = BloodRequest::find($request->blood_request_id);
            if ($bloodRequest) {
                $bloodRequest->update(['status' => 'fulfilled']);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Donation recorded successfully.',
            'donation' => $donation
        ]);
    }
}
