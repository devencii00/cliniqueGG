<?php

namespace App\Events;

use App\Models\QueueEntry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public QueueEntry $queueEntry;
    public string $type;

    public function __construct(QueueEntry $queueEntry, string $type = 'joined')
    {
        $this->queueEntry = $queueEntry;
        $this->type = $type;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('queue'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'queue.joined';
    }

    public function broadcastWith(): array
    {
        $this->queueEntry->load('user');
        return [
            'id'            => $this->queueEntry->id,
            'user_id'       => $this->queueEntry->user_id,
            'queue_number'  => $this->queueEntry->queue_number,
            'status'        => $this->queueEntry->status,
            'window_number' => $this->queueEntry->window_number,
            'user_name'     => $this->queueEntry->user?->name ?? 'Unknown',
            'type'          => $this->type,
            'created_at'    => $this->queueEntry->created_at->toISOString(),
            'fired_at'      => (int) round(microtime(true) * 1000),
        ];
    }
}
