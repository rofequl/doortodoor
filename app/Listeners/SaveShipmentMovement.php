<?php

namespace App\Listeners;

use App\Events\ShipmentMovement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Shipment_movement;
class SaveShipmentMovement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ShipmentMovement  $event
     * @return void
     */
    public function handle(ShipmentMovement $event)
    {
        Shipment_movement::create([
            'shipment_id'=>$event->shipment_id,
            'user_type'=>$event->user_type,
            'user_id'=>$event->user_id,
            'report_type'=>$event->report_type,
            'note'=>$event->note,
            'status'=>$event->status,
        ]);

    }
}
