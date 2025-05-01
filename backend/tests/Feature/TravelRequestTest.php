<?php

namespace Tests\Feature;

use App\Http\Controllers\TravelRequestController;
use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_logged_can_create_travel_request(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');


        $payload = [
            'requester_name' => $user->name,
            'destination' => 'Belo Horizonte',
            'departure_date' => now()->addDays(3)->format('Y-m-d'),
            'return_date' => now()->addDays(7)->format('Y-m-d')
        ];

        $responseRequest = $this->actingAs($user)->postJson('/api/travel-requests', 
            $payload
        );

        $responseRequest->assertStatus(201)->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'requester_name',
                'destination',
                'departure_date',
                'return_date',
                'created_at',
                'updated_at'
            ]
        ]);

        $this->assertDatabaseHas('travel_requests', [
            'requester_name' => $user->name,
            'destination' => 'Belo Horizonte',
        ]);
    }
}
