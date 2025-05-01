<?php

namespace Tests\Feature;

use App\Enums\TravelRequestStatus;
use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_own_travel_request()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $payload = [
            'user_id' => $user->id,
            'requester_name' => $user->name,
            'status' => 'requested'
        ];

        $travelRequest = TravelRequest::factory()->create($payload);

        $response = $this->patchJson("/api/travel-requests/{$travelRequest->id}/status", ['status' => 'approved']);

        $response->assertStatus(403)->assertJson([
            'message' => "Você não pode alterar o status do próprio pedido"
        ]);

    }


    public function test_another_user_can_update_travel_request_status()
    {
        $userOwner = User::factory()->create();
        $userManager = User::factory()->create();

        $payload = [
            'user_id' => $userOwner->id,
            "requester_name" => $userOwner->name,
            "status" => 'requested'
        ];

        $travelRequest = TravelRequest::factory()->create(
            $payload
        );

        $this->actingAs($userManager);

        $response = $this->patchJson("/api/travel-requests/{$travelRequest->id}/status", [
            "status" => "approved"
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'message' => "Status atualizado com sucesso!",
            'data' => [
                'id' => $travelRequest->id,
                'status' => 'approved'
            ]
            ]);

        
        $this->assertDatabaseHas('travel_requests', [
            'id' => $travelRequest->id,
            'status' => 'approved'

        ]);

    }
}
