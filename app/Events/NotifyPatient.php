<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyPatient implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $doctorid;
    public $patientid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($doctorid,$patientid)
    {
        //
        
        $this->doctorid = $doctorid;
        $this->patientid = $patientid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('patient-channel');
    }

    public function broadcastAs()
    {
        return 'notify-patient';
    }
}
