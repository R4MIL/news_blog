<?php

namespace App\Events;

use Faker\Core\Number;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreQtyBlogCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private array $commentsQty;

    public function __construct(array $commentsQty)
    {
        $this->commentsQty = $commentsQty;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('blog-comments-qty'),
        ];
    }
    public function broadcastAs(): string
    {
        return 'comment.stored';
    }

    public function broadcastWith(): array
    {
        return [
            'commentsQty' => $this->commentsQty
        ];
    }
}
