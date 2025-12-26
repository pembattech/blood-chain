<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBloodRequestRequest;
use App\Http\Requests\UpdateBloodRequestRequest;
use App\Http\Resources\V1\BloodRequestResource;
use App\Services\BloodMatchingService;
use App\Models\BloodRequest;

class BloodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloodRequests = BloodRequest::latest()->paginate(10);
        return BloodRequestResource::collection($bloodRequests);
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
        return new BloodRequestResource($bloodRequest);
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
