<?php

namespace App\Events\Autores;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\BroadcastManager;

class UpdateAutoresEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $id;
    public $nombre;
    public $apellidos;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $nombre, $apellidos)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('update-autor-channel');
    }

    public function broadcastAs()
    {
        return 'update-autor-event';
    }
}
