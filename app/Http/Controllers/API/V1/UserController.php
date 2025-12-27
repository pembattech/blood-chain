<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloodDonation;


class UserController extends Controller
{
    public function profileStatus(Request $request)
    {

        $user = $request->user();

        return response()->json([
            'profile_complete' => $user->isProfileComplete(),
            'message' => $user->isProfileComplete()
                ? '✅ Donor profile already exists.'
                : '⛔ Please complete donor profile.',
            'user' => $user,
            'status' => $user->isProfileComplete()
                ? true : false
        ]);

    }


    public function profile(Request $request)
    {
        $user = $request->user();

        $donor = $user->donor;

        // Fetch donations count
        $donationsCount = $donor ? BloodDonation::where('donor_id', $donor->id)->count() : 0;


        // Fetch last donation
        $lastDonation = BloodDonation::where('donor_id', $donor->id)
            ->latest('date')
            ->first();

        // Fetch all donations for history
        $donations = BloodDonation::where('donor_id', $donor->id)
            ->orderByDesc('date')
            ->get(['location', 'date', 'units', 'status']);

        // Optional: rank logic
        $rank = $donationsCount >= 20 ? 'Platinum' :
            ($donationsCount >= 10 ? 'Gold' :
                ($donationsCount >= 5 ? 'Silver' : 'Bronze'));

        return response()->json([
            'user' => $user,
            'donations_count' => $donationsCount,
            // 'rank' => $rank,
            'last_donation' => $lastDonation ? $lastDonation : null,
            'donations' => $donations,
        ]);


    }
}
