<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use App\Models\BloodRequest;;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    /**
     * Fetch blood requests compatible with logged-in user's blood type
     */
    public function fetchMatching(Request $request)
    {
        $user = $request->user();

        // Get compatible recipient blood types
        $compatibleRecipientTypes = $this->compatibleRecipients(
            $user->blood_type
        );

        // Fetch matching blood requests
        $bloodRequests = BloodRequest::whereIn(
            'blood_type_needed',
            $compatibleRecipientTypes
        )
            ->where('status', 'pending') // optional but recommended
            ->latest()
            ->get();

        // 4️⃣ Response
        return response()->json([
            'success' => true,
            'user_blood_type' => $user->blood_type,
            'compatibleRecipientTypes' => $compatibleRecipientTypes,
            'total_matches' => $bloodRequests->count(),
            'matches' => $bloodRequests
        ]);
    }

    /**
     * Blood compatibility (donor → recipient)
     */
    private function compatibleRecipients(string $donorType): array
    {
        return match ($donorType) {
            'O-' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'O+' => ['A+', 'B+', 'AB+', 'O+'],
            'A-' => ['A+', 'A-', 'AB+', 'AB-'],
            'A+' => ['A+', 'AB+'],
            'B-' => ['B+', 'B-', 'AB+', 'AB-'],
            'B+' => ['B+', 'AB+'],
            'AB-' => ['AB+', 'AB-'],
            'AB+' => ['AB+'],
            default => [],
        };
    }
}
