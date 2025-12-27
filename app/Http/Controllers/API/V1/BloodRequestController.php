<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBloodRequestRequest;
use App\Http\Requests\UpdateBloodRequestRequest;
use App\Http\Resources\V1\BloodRequestResource;
use App\Services\BloodMatchingService;
use App\Models\BloodRequest;
use App\Models\Donor;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Returns only blood requests compatible with the logged-in user’s blood type
     * Calculates distance from user geolocation
     * Adds compatible donors count
     */
    // public function index()
    // {
    //     $bloodRequests = BloodRequest::latest()->paginate(10);
    //     return BloodRequestResource::collection($bloodRequests);
    // }


    public function index(Request $request)
    {
        $user = $request->user();
        $userBloodType = $user->blood_type ?? null;

        // Initialize query
        $query = BloodRequest::latest();

        // Only show requests compatible with user's blood type
        if ($userBloodType) {
            $compatibleRequests = $this->compatibleRecipients($userBloodType);
            $query->whereIn('blood_type_needed', $compatibleRequests);
        }

        // Only show requests that are not fulfilled
        $query->where('status', '!=', 'fulfilled');

        // Pagination
        $bloodRequests = $query->paginate(10);

        $userLat = $request->user_lat;
        $userLng = $request->user_lng;

        // Transform results
        $bloodRequests->getCollection()->transform(function ($req) use ($userLat, $userLng) {
            // Calculate distance
            $req->distance = ($userLat && $userLng && $req->location_lat)
                ? round($this->calculateDistance($userLat, $userLng, $req->location_lat, $req->location_lng), 2)
                : null;

            $req->posted = $req->created_at->diffForHumans();

            // Compatible donors count
            $compatibleTypes = $this->compatibleDonors($req->blood_type_needed);
            $req->compatible_donors_count = Donor::where('available', true)
                ->whereHas('user', fn($q) => $q->whereIn('blood_type', $compatibleTypes))
                ->count();

            return $req;
        });

        return response()->json([
            'user' => $user->load('donor'),
            'data' => $bloodRequests->items(),
            'meta' => [
                'current_page' => $bloodRequests->currentPage(),
                'last_page' => $bloodRequests->lastPage(),
                'total' => $bloodRequests->total(),
            ]
        ]);
    }

    /**
     * Return all recipient blood types that the donor's blood type is compatible with
     */
    private function compatibleRecipients(string $donorType): array
    {
        return match ($donorType) {
            'O+' => ['O+', 'A+', 'B+', 'AB+'],
            'O-' => ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'],
            'A+' => ['A+', 'AB+'],
            'A-' => ['A+', 'A-', 'AB+', 'AB-'],
            'B+' => ['B+', 'AB+'],
            'B-' => ['B+', 'B-', 'AB+', 'AB-'],
            'AB+' => ['AB+'],
            'AB-' => ['AB+', 'AB-'],
            default => [],
        };
    }


    // public function index(Request $request, BloodMatchingService $service)
    // {
    //     $query = BloodRequest::latest();

    //     if ($request->search) {
    //         $query->where('hospital', 'like', "%{$request->search}%")
    //             ->orWhere('city', 'like', "%{$request->search}%")
    //             ->orWhere('blood_type_needed', 'like', "%{$request->search}%");
    //     }

    //     if ($request->blood_type) {
    //         $query->where('blood_type_needed', $request->blood_type);
    //     }

    //     $bloodRequests = $query->paginate(10);

    //     $userLat = $request->user_lat;
    //     $userLng = $request->user_lng;

    //     $bloodRequests->getCollection()->transform(function ($req) use ($userLat, $userLng, $service) {
    //         // Calculate distance if coordinates provided
    //         if ($userLat && $userLng) {
    //             $req->distance = round($this->calculateDistance(
    //                 $userLat,
    //                 $userLng,
    //                 $req->location_lat,
    //                 $req->location_lng
    //             ), 2);
    //         } else {
    //             $req->distance = null;
    //         }

    //         // Human-readable posted time
    //         $req->posted = $req->created_at->diffForHumans();

    //         // Compatible donors
    //         $compatibleTypes = $service->compatibleDonors($req->blood_type_needed);
    //         $req->compatible_donors_count = \App\Models\Donor::where('available', true)
    //             ->whereHas('user', fn($q) => $q->whereIn('blood_type', $compatibleTypes))
    //             ->count();

    //         return $req;
    //     });

    //     return BloodRequestResource::collection($bloodRequests);
    // }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);
        return $r * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

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


    /**
     * Show the form for creating a new resource.
     * Not needed for API, can be removed or kept empty.
     */
    public function create()
    {
        return response()->json(['message' => 'Use store endpoint to create a blood request.'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreBloodRequestRequest $request)
    // {
    //     $user = auth()->user();

    //     $bloodRequest = BloodRequest::create(array_merge(
    //         $request->validated(),
    //         ['recipient_id' => $user->id]
    //     ));

    //     return response()->json(new BloodRequestResource($bloodRequest), 201);
    // }

    public function store(
        StoreBloodRequestRequest $request,
        BloodMatchingService $matcher
    ) {
        // Create the blood request
        $bloodRequest = BloodRequest::create([
            ...$request->validated()
        ]);

        // Run matching algorithms with fallback
        $matcher->handle($bloodRequest);

        // Reload the request with matches and donor info
        $bloodRequest->load([
            'matches.donor.user'
        ]);

        // Build clean matches array
        $matches = $bloodRequest->matches->map(function ($match) {
            return [
                'match_id' => $match->id,
                'donor_id' => $match->donor->id,
                'donor_name' => $match->donor->user->name,
                'blood_type' => $match->donor->user->blood_type,
                'status' => $match->status,
            ];
        });

        // Return structured JSON
        return response()->json([
            'message' => 'Blood request created & donors notified',
            'request' => [
                'id' => $bloodRequest->id,
                'blood_type_needed' => $bloodRequest->blood_type_needed,
                'urgency' => $bloodRequest->urgency,
                'location_lat' => $bloodRequest->location_lat,
                'location_lng' => $bloodRequest->location_lng,
                'recipient_id' => $bloodRequest->recipient_id,
                'status' => $bloodRequest->status,
                'created_at' => $bloodRequest->created_at,
                'updated_at' => $bloodRequest->updated_at
            ],
            'matches_count' => $matches->count(),
            'matches' => $matches
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(BloodRequest $bloodRequest)
    {
        $request = BloodRequest::with('recipient')->find($bloodRequest->id);

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'Blood request not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'request' => [
                'id' => $request->id,
                'blood_type_needed' => $request->blood_type_needed,
                'urgency' => $request->urgency,
                'location' => [
                    'lat' => $request->location_lat,
                    'lng' => $request->location_lng,
                ],
                'status' => $request->status,
                'recipient' => [
                    'name' => $request->recipient->name,
                    'phone' => $request->recipient->phone,
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * Not needed for API, can be removed or kept empty.
     */
    public function edit(BloodRequest $bloodRequest)
    {
        return response()->json(['message' => 'Use update endpoint to edit a blood request.'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBloodRequestRequest $request, BloodRequest $bloodRequest)
    {
        $bloodRequest->update($request->validated());
        return new BloodRequestResource($bloodRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BloodRequest $bloodRequest)
    {
        $bloodRequest->delete();
        return response()->json(['message' => 'Blood request deleted successfully.'], 200);
    }
}
