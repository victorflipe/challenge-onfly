<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use App\Notifications\TravelRequestStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TravelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TravelRequest::query();

        //var_dump($query);

        if($request->has('status')){
            $query->where('status', $request->input('status'));
        }

        if($request->has('departure_date')){
            $query->where('departure_date', ">=", $request->input('departure_date'));
        }

        if($request->has('return_date')){
            $query->where('return_date', "<=", $request->input('return_date'));
        }

        if($request->has('destination')){
            $query->where('destination', 'like', '%' . $request->input('destination') . '%');
        }

        //$reservas = $query->orderBy('created_at', 'desc')->paginate(10);

        //return response()->json($reservas);
        return response()->json($query->latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function update(Request $request, TravelRequest $travelRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,canceled',
        ]);

        // Regra de negócio: o solicitante não pode mudar o próprio pedido
        if ($travelRequest->user_id == Auth::id()) {
            return response()->json([
                'message' => 'Você não pode alterar o status do seu próprio pedido.'
            ], 403);
        }

        // Se tentar cancelar um pedido aprovado
        if ($travelRequest->status === 'approved' && $validated['status'] === 'canceled') {
            // Aqui você pode validar regras específicas, por exemplo: só gerentes podem cancelar
        }

        $travelRequest->update([
            'status' => $validated['status'],
        ]);

        // Disparar notificação
        Notification::route('mail', $travelRequest->user->email)
            ->notify(new TravelRequestStatusUpdated($travelRequest));

        return response()->json([
            'message' => 'Status atualizado com sucesso.',
            'data' => $travelRequest,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelRequest $travelRequest)
    {
        //
    }


    public function updateStatus(Request $request, $id){
        $request->validate([
            'status' => 'required|in:approved,canceled'
        ]);

        $travelRequest = TravelRequest::findOrFail($id);

        if($travelRequest->user_id === Auth::user()->id){
            return response()->json([
                'message' => 'Você não pode alterar o status do próprio pedido'
            ], 403);        
        }

        $travelRequest->update([
            'status' => $request->status
        ]);

        $travelRequest->user->notify(new TravelRequestStatusUpdated($travelRequest));


        return response()->json([
            'message' => 'Status atualizado com sucesso!',
            'data' => $travelRequest
        ]);
    }
}
