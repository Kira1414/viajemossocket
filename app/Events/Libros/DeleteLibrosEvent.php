<?php

namespace App\Events\Libros;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\BroadcastManager;

class DeleteLibrosEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $isbn;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($isbn,$status)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->isbn = $isbn;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('delete-libro-channel');
    }

    public function broadcastAs()
    {
        return 'delete-libro-event';
    }
}
