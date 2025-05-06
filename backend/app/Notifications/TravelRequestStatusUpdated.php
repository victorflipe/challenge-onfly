<?php

namespace App\Notifications;

use App\Models\TravelRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelRequestStatusUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(TravelRequest $travelRequest)
    {
        $this->travelRequest = $travelRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Status of Requested Travel updated successfully')
            ->line('Requested Travel updated successfully')
            ->line('----------------------------------------------------')
            ->line(' ')
            ->line(' ')
            ->line('    Travel Request: '. $this->travelRequest->id)
            ->line('    Destination: '. $this->travelRequest->destination)
            ->line('    Departure Date: '. $this->travelRequest->departure_date->format('m/d/Y'))
            ->line('    Return Date: '. $this->travelRequest->return_date->format('m/d/Y'))
            ->line('    Status: '. $this->travelRequest->status->name)
            ->line('')
            ->line('----------------------------------------------------')
            // ->action('Notification Action', url('/'))
            ->line(' ')
            ->line(' ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
