<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestCancelTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @todo Implementar algo em que o cancelamento possa ser feito até 24 horas antes do momento da viagem
     */
    public function test_requester_cannot_cancel_their_own_approved_request():void{

        $requester = User::factory()->create([
            'name' => 'Solicitante'
        ]);

        $travelRequest = TravelRequest::factory()->create([
            'user_id' => $requester->id,
            'requester_name' => $requester->name,
            'status' => 'approved'
        ]);

        $response = $this->actingAs($requester)->patchJson("/api/travel-requests/{$travelRequest->id}/status", [
            'status' => 'canceled'
        ]);


        $response->assertStatus(403);

        $this->assertDatabaseHas('travel_requests', [
            'id' => $travelRequest->id,
            'status' => 'approved'
        ]);

    }
}
