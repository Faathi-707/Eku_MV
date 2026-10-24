<?php

namespace App\Notifications;

use App\Models\DisruptionReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent synchronously so the database copy appears in citizens' inboxes
 * immediately; the broadcast copy is still queued for real-time delivery.
 */
class NewDisruptionReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public DisruptionReport $report) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'category' => $this->report->category->value,
            'title' => 'New Disruption Report',
            'message' => "A new disruption has been reported: {$this->report->category->label()}",
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
