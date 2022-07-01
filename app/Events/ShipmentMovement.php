<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentMovement
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shipment_id;
    public $user_type;
    public $user_id;
    public $note;
    public $report_type;
    public $status;

    public function __construct($shipment_id, $user_type, $user_id,$report_type,$note,$status){
        $this->shipment_id = $shipment_id;   
        $this->user_type = $user_type;   
        $this->user_id = $user_id;   
        $this->note = $note;   
        $this->status = $status; 
        $this->report_type = $report_type;  
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
