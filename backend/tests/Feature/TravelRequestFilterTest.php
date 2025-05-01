<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_travel_requests_by_destination_and_date_range(): void
    {

        $user = User::factory()->create();

        $this->actingAs($user);

        TravelRequest::factory()->create([
            'user_id' => $user->id,
            'destination' => 'São Paulo',
            'departure_date' => '2025-06-01',
            'return_date' => '2025-06-05',
        ]);

        TravelRequest::factory()->create([
            'user_id' => $user->id,
            'destination' => 'Rio de Janeiro',
            'departure_date' => '2025-06-10',
            'return_date' => '2025-06-15',
        ]);

        TravelRequest::factory()->create([
            'user_id' => $user->id,
            'destination' => 'Salvador',
            'departure_date' => '2025-07-01',
            'return_date' => '2025-07-05',
        ]);

        $response = $this->getJson('/api/travel-requests?destination=rio&departure_date=2025-06-01&return_date=2025-06-30');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['destination' => 'Rio de Janeiro']);
    }
}
