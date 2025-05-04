<?php

namespace App\Http\Controllers;

use App\Enums\TravelRequestStatus;
use App\Models\TravelRequest;
use App\Notifications\TravelRequestStatusUpdated;
use App\Services\TravelRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TravelRequestController extends Controller
{

    // protected $service;

    public function __construct(protected TravelRequestService $service)
    {
        // $this->service = $service;
    }

    public function index(Request $request)
    {
        // $requests = TravelRequest::search($request)->paginate(10);
        $requests = $this->service->all($request);
        return response()->json([
            'data' => $requests
        ]);
        // // dd($this->service);
        // return response()->json($this->service->all());
    }

    public function index2(Request $request)
    {
        $query = TravelRequest::query();


        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('departure_date')) {
            $query->where('departure_date', ">=", $request->input('departure_date'));
        }

        if ($request->has('return_date')) {
            $query->where('return_date', "<=", $request->input('return_date'));
        }

        if ($request->has('destination')) {
            $query->where('destination', 'like', '%' . $request->input('destination') . '%');
        }

        //$reservas = $query->orderBy('created_at', 'desc')->paginate(10);

        //return response()->json($reservas);
        return response()->json($query->latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        // $created = $this->service->update($validated, );
        return response()->json($validated, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:departure_date'
        ]);

        $travelRequest = TravelRequest::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            //'message' => 'Pedido de viagem criado com sucesso.',
            'message' => 'Travel request created successfully.',
            'data' => $travelRequest,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $travelRequest = TravelRequest::findOrFail($id);
        return response()->json($travelRequest);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelRequest $travelRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, TravelRequest $travelRequest)
    // {
    //     $validated = $request->validate([
    //         'status' => 'required|in:approved,canceled',
    //     ]);

    //     // Regra de negócio: o solicitante não pode mudar o próprio pedido
    //     if ($travelRequest->user_id == Auth::id()) {
    //         return response()->json([
    //             'message' => 'Você não pode alterar o status do seu próprio pedido.'
    //         ], 403);
    //     }

    //     // Se tentar cancelar um pedido aprovado
    //     if ($travelRequest->status === 'approved' && $validated['status'] === 'canceled') {
    //         // Aqui você pode validar regras específicas, por exemplo: só gerentes podem cancelar
    //     }

    //     $travelRequest->update([
    //         'status' => $validated['status'],
    //     ]);

    //     // Disparar notificação
    //     Notification::route('mail', $travelRequest->user->email)
    //         ->notify(new TravelRequestStatusUpdated($travelRequest));

    //     return response()->json([
    //         'message' => 'Status atualizado com sucesso.',
    //         'data' => $travelRequest,
    //     ]);
    // }

    /**
     * Remove the specified resource from storage.
     */
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

        if ($travelRequest->user_id === Auth::user()->id || !Auth::user()->is_admin) {
            return response()->json([
                'message' => 'Você não pode alterar o status do próprio pedido'
            ], 403);
        }
        // new TravelRequestStatusUpdated($travelRequest);
        // dd();
        // dd($travelRequest);
        $travelRequest->update([
            'status' => TravelRequestStatus::from($request->status)
        ]);

        // Disparar notificação
        Notification::route('mail', $travelRequest->user->email)
            ->notify(new TravelRequestStatusUpdated($travelRequest));

        // $travelRequest->user->notify(new TravelRequestStatusUpdated($travelRequest));


        return response()->json([
            'message' => 'Status updated successfully!',
            'data' => $travelRequest
        ]);
    }
}
