<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertCall implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $alert;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($alert)
    {
        //
        $this->alert = $alert;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('call-alert');
    }
    public function broadcastAs()
    {
        return 'call-alert';
    }
}
