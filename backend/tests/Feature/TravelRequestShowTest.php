<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_own_travel_request():void{
        $user = User::factory()->create();

        $this->actingAs($user);

        $travelRequest = TravelRequest::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson("/api/travel-requests/{$travelRequest->id}");

        $response->assertStatus(200)
        ->assertJsonFragment([
            'user_id' => $travelRequest->user_id,
            'requester_name' => $travelRequest->requester_name,
            'destination' => $travelRequest->destination
        ]);
    }
    

    public function test_returns_404_if_travel_request_not_found(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/travel-requests/9999');

        $response->assertStatus(404);
    }
}
