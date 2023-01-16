<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherMaker  implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $eventInd;

    public function __construct($message, $eventInd="my-event")
    {
        $this->message = $message;
        $this->eventInd = $eventInd;
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return $this->eventInd;
    }
}
