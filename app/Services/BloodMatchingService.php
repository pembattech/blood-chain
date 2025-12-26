<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\matches;
use Carbon\Carbon;

class BloodMatchingService
{
    /**
     * Handle matching with fallback:
     * Nearest → Priority → Round Robin
     */
    public function handle(BloodRequest $request)
    {
        if ($this->nearest($request)) return;
        if ($this->priority($request)) return;
        $this->roundRobin($request);
    }

    /* ---------------------------------------- */
    /*  Algorithm 1: Nearest Donor               */
    /* ---------------------------------------- */
    private function nearest(BloodRequest $request, int $limit = 5): bool
    {
        $compatibleTypes = $this->compatibleDonors($request->blood_type_needed);

        $donors = Donor::with('user')
            ->select('*')
            ->selectRaw("
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(location_lat)) *
                    cos(radians(location_lng) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(location_lat))
                )) AS distance
            ", [
                $request->location_lat,
                $request->location_lng,
                $request->location_lat
            ])
            ->where('available', true)
            ->whereHas('user', fn($q) =>
                $q->whereIn('blood_type', $compatibleTypes)
            )
            ->orderBy('distance')
            ->limit($limit)
            ->get();

        return $this->createMatches($donors, $request);
    }

    /* ---------------------------------------- */
    /*  Algorithm 2: Priority Based              */
    /* ---------------------------------------- */
    private function priority(BloodRequest $request, int $limit = 5): bool
    {
        $compatibleTypes = $this->compatibleDonors($request->blood_type_needed);

        $donors = Donor::with('user')
            ->where('available', true)
            ->whereHas('user', fn($q) =>
                $q->whereIn('blood_type', $compatibleTypes)
            )
            ->get()
            ->map(function ($donor) use ($request) {
                $score = 0;

                // Exact match bonus
                if ($donor->user->blood_type === $request->blood_type_needed)
                    $score += 10;

                // Last donation months
                if ($donor->last_donation_date) {
                    $months = Carbon::parse($donor->last_donation_date)
                        ->diffInMonths(now());
                    $score += min($months, 5);
                }

                // Distance score
                $distance = $this->distance(
                    $donor->location_lat,
                    $donor->location_lng,
                    $request->location_lat,
                    $request->location_lng
                );
                $score += $distance <= 5 ? 5 : ($distance <= 10 ? 3 : 1);

                $donor->score = $score;
                return $donor;
            })
            ->sortByDesc('score')
            ->take($limit);

        return $this->createMatches($donors, $request);
    }

    /* ---------------------------------------- */
    /*  Algorithm 3: Round Robin                 */
    /* ---------------------------------------- */
    private function roundRobin(BloodRequest $request, int $limit = 5): bool
    {
        $compatibleTypes = $this->compatibleDonors($request->blood_type_needed);

        $donors = Donor::with('user')
            ->where('available', true)
            ->whereHas('user', fn($q) =>
                $q->whereIn('blood_type', $compatibleTypes)
            )
            ->orderBy('last_notified_at', 'asc')
            ->limit($limit)
            ->get();

        foreach ($donors as $donor) {
            matches::create([
                'blood_request_id' => $request->id,
                'donor_id' => $donor->id,
                'status' => 'pending'
            ]);

            $donor->update(['last_notified_at' => now()]);
        }

        return $donors->count() > 0;
    }

    /* ---------------------------------------- */
    /*  Helper: Create Matches                   */
    /* ---------------------------------------- */
    private function createMatches($donors, BloodRequest $request): bool
    {
        if ($donors->isEmpty()) return false;

        foreach ($donors as $donor) {
            matches::create([
                'blood_request_id' => $request->id,
                'donor_id' => $donor->id,
                'status' => 'pending'
            ]);
        }

        return true;
    }

    /* ---------------------------------------- */
    /*  Helper: Distance (km)                    */
    /* ---------------------------------------- */
    private function distance($lat1, $lng1, $lat2, $lng2)
    {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) ** 2;

        return $r * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }

    /* ---------------------------------------- */
    /*  Helper: Blood Type Compatibility         */
    /* ---------------------------------------- */
    private function compatibleDonors(string $recipientType): array
    {
        return match ($recipientType) {
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-'],
            default => [],
        };
    }
}
