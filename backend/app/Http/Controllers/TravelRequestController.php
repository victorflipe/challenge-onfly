<?php

namespace App\Http\Controllers;

use App\Enums\TravelRequestStatus;
use App\Models\TravelRequest;
use App\Notifications\TravelRequestStatusUpdated;
use App\Services\TravelRequestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TravelRequestController extends Controller
{

    public function __construct(protected TravelRequestService $service)
    {
    }

    public function index(Request $request)
    {
        $requests = $this->service->all($request);
        return response()->json([
            'data' => $requests
        ]);
       
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        $travelRequest = [
            ...$validated,
            'user_id' => auth()->id(),
        ];

        $created = $this->service->create($travelRequest);
        return response()->json([
            'message' => 'Travel request created successfully.',
            'data' => $created,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        $update = $this->service->update($validated, $id);
        return response()->json([
            'message' => 'Travel request updated successfully.',
            'data' => $update,
        ], 200);
    }

   
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $travelRequest = TravelRequest::findOrFail($id);
        return response()->json($travelRequest);
    }

    public function destroy(TravelRequest $travelRequest)
    {
        //
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,canceled'
        ]);

        $travelRequest = TravelRequest::findOrFail($id);

        if ($travelRequest->user_id === Auth::user()->id && !Auth::user()->is_admin) {
            return response()->json([
                'message' => 'You cannot change the status of the order itself.'
            ], 403);
        }
        $travelRequest->update([
            'status' => TravelRequestStatus::from($request->status)
        ]);

        Notification::route('mail', $travelRequest->user->email)
            ->notify(new TravelRequestStatusUpdated($travelRequest));


        return response()->json([
            'message' => 'Status updated successfully!',
            'data' => $travelRequest
        ]);
    }

    public function checkUpdateStatus(int $id){
        
        $travelRequest = TravelRequest::findOrFail($id);

        if (Carbon::now()->greaterThanOrEqualTo(Carbon::parse($travelRequest->departure_date)->subDay()) && $travelRequest->status === "approved") {
            return response()->json([
                'message' => 'You cannot change the status of the order.'
            ], 403);
        }

        return response()->json([
            'message' => 'Status can be updated.'
        ], 200);

    }
}
