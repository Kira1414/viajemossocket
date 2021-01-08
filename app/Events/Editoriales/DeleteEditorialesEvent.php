<?php

namespace App\Events\Editoriales;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\BroadcastManager;

class DeleteEditorialesEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $id;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $status)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('delete-editorial-channel');
    }

    public function broadcastAs()
    {
        return 'delete-editorial-event';
    }
}
