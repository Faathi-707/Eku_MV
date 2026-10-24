<?php

namespace App\Events;

use App\Models\CommunityPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommunityPostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public CommunityPost $post) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('community'),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array{id: int, type: string, type_label: string, message: string, location: string, photo_url: ?string, author: string, distress_status: ?string}
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->post->id,
            'type' => $this->post->type->value,
            'type_label' => $this->post->type->label(),
            'message' => $this->post->message,
            'location' => $this->post->location,
            'photo_url' => $this->post->photoUrl(),
            'author' => $this->post->user->name,
            'distress_status' => $this->post->distress_status?->label(),
        ];
    }
}
