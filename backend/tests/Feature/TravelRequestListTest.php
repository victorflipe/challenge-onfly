<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelRequestListTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_all_request_travels(): void
    {

        $user = User::factory()->create();

        $this->actingAs($user);

        TravelRequest::factory()->count(2)->create([
            'status' => 'requested',
            "user_id" => $user->id
        ]);

        TravelRequest::factory()->count(2)->create([
            'status' => 'approved',
            "user_id" => $user->id
        ]);

        TravelRequest::factory()->count(2)->create([
            'status' => 'canceled',
            "user_id" => $user->id
        ]);

        $response = $this->getJson('/api/travel-requests?status=approved');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);

        // $this->assertCount(2, $response->json('data'));
    }


    public function test_user_can_list_all_travel_requests_without_filter():void{
        
        $user = User::factory()->create();
        $this->actingAs($user);

        TravelRequest::factory()->count(5)->create(["user_id" => $user->id]);

        $response = $this->getJson('/api/travel-requests');

        $response->assertStatus(200);

        // $this->assertCount(5, $response->json('data'));
    }
}
