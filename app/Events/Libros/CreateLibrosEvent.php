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

class CreateLibrosEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'sync';
    public $isbn;
    public $editoriales_id;
    public $titulo;
    public $sinopsis;
    public $n_paginas;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($isbn,$editoriales_id,$titulo,$sinopsis,$n_paginas,$status)
    {
        $broadcastManager = new BroadcastManager( app() );
        $broadcastManager->setDefaultDriver("pusher");
        $this->isbn = $isbn;
        $this->editoriales_id = $editoriales_id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->n_paginas = $n_paginas;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('create-libro-channel');
    }

    public function broadcastAs()
    {
        return 'create-libro-event';
    }
}
