<?php

namespace App\Notifications;

use App\Enums\CommunityPostType;
use App\Models\CommunityPost;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent synchronously so officials see the alert immediately; the broadcast copy is queued.
 */
class NewCommunityPost extends Notification
{
    use Queueable;

    public function __construct(public CommunityPost $post) {}

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
        $isDistress = $this->post->type === CommunityPostType::Distress;

        return [
            'post_id' => $this->post->id,
            'post_type' => $this->post->type->value,
            'urgent' => $isDistress,
            'title' => $isDistress ? 'Distress Call' : "Citizen {$this->post->type->label()} Report",
            'message' => "{$this->post->user->name} at {$this->post->location}: {$this->post->message}",
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
