<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use App\Models\User;
use App\Notifications\TravelRequestStatusUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TravelRequestNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_receives_notification_when_request_is_canceled():void{

        Notification::fake();

        $requester = User::factory()->create([
            'name' => 'Requester',
            'email' => 'requester@email.com'
        ]);

        $admin = User::factory()->create([
            'name' => 'Approver'
        ]);

        $travelRequest = TravelRequest::factory()->create([
            'user_id' => $requester->id,
            'requester_name' => $requester->name,
            'status' => 'requested'
        ]);

        $response = $this->actingAs($admin)->patchJson("/api/travel-requests/{$travelRequest->id}/status", [
            'status' => 'approved'
        ]);

        $response->assertStatus(200);

        Notification::assertSentTo($requester, TravelRequestStatusUpdated::class);
    }
}
