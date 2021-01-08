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

class CreateEditorialesEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $id;
    public $nombre;
    public $sede;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $nombre, $sede, $status)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->id = $id;
        $this->nombre = $nombre;
        $this->sede = $sede;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //dd("llegando CreateEditorialesEvent");
        return new Channel('create-editorial-channel');
    }

    public function broadcastAs()
    {
        return 'create-editorial-event';
    }
}
