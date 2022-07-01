<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendingSMS
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver_type; public $sent_to; public $message_body;

    public function __construct($receiver_type, $sent_to,$message_body){
        $this->receiver_type = $receiver_type;
        $this->sent_to = $sent_to;
        
        $this->message_body = $message_body;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
