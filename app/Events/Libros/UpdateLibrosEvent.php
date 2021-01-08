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

class UpdateLibrosEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $isbn;
    public $editoriales_id;
    public $titulo;
    public $sinopsis;
    public $n_paginas;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($isbn,$editoriales_id,$titulo,$sinopsis,$n_paginas)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->isbn = $isbn;
        $this->editoriales_id = $editoriales_id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->n_paginas = $n_paginas;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('update-libro-channel');
    }

    public function broadcastAs()
    {
        return 'update-libro-event';
    }
}
