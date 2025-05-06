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

    public function test_user_receives_notification_when_request_is_approved():void{

        Notification::fake();

        $requester = User::factory()->create([
            'name' => 'Requester',
            'email' => 'requester@email.com'
        ]);

        $admin = User::factory()->create([
            'name' => 'Approver',
            'is_admin' => true
        ]);

        $travelRequest = TravelRequest::factory()->create([
            'user_id' => $requester->id,
            'requester_name' => $requester->name,
            'status' => 'requested'
        ]);

        $this->actingAs($admin)->patchJson("/api/travel-requests/{$travelRequest->id}/status", [
            'status' => 'approved'
        ]);

        Notification::assertSentOnDemand(
            TravelRequestStatusUpdated::class,
            function ($notification, $channels, $notifiable) use ($requester) {
                return $notifiable->routes['mail'] === $requester->email;
            }
        );

    }

    public function test_user_receives_notification_when_request_is_canceled():void{

        Notification::fake();

        $requester = User::factory()->create([
            'name' => 'Requester',
            'email' => 'requester@email.com'
        ]);

        $admin = User::factory()->create([
            'name' => 'Approver',
            'is_admin' => true
        ]);

        $travelRequest = TravelRequest::factory()->create([
            'user_id' => $requester->id,
            'requester_name' => $requester->name,
            'status' => 'requested'
        ]);

        $this->actingAs($admin)->patchJson("/api/travel-requests/{$travelRequest->id}/status", [
            'status' => 'canceled'
        ]);

        Notification::assertSentOnDemand(
            TravelRequestStatusUpdated::class,
            function ($notification, $channels, $notifiable) use ($requester) {
                return $notifiable->routes['mail'] === $requester->email;
            }
        );
    }
}
