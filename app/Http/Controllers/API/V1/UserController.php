<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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
            'user' => $user
        ]);

    }


    public function profile(Request $request)
    {
        $user = $request->user();

        // Fetch donations count
        $donationsCount = BloodDonation::where('donor_id', $user->id)->count();

        // Fetch last donation
        $lastDonation = BloodDonation::where('donor_id', $user->id)
            ->latest('date')
            ->first();

        // Fetch all donations for history
        $donations = BloodDonation::where('donor_id', $user->id)
            ->orderByDesc('date')
            ->get(['location', 'date', 'units', 'status']);

        // Optional: rank logic
        $rank = $donationsCount >= 20 ? 'Platinum' :
            ($donationsCount >= 10 ? 'Gold' :
                ($donationsCount >= 5 ? 'Silver' : 'Bronze'));

        return response()->json([
            'user' => $user,
            'donations_count' => $donationsCount,
            'rank' => $rank,
            'last_donation' => $lastDonation ? $lastDonation->date->format('Y-m-d') : null,
            'donations' => $donations,
        ]);
    }
}
