<?php

namespace App\Listeners;

use App\Events\SendingSMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Shipment;
use App\Send_sms;

class SendSMS
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
     * @param  SendingSMS  $event
     * @return void
     */
    public function handle(SendingSMS $event)
    {
        Send_sms::create([
            'receiver_type'=>$event->receiver_type,
            'sent_to'=>$event->sent_to,
            'message_body'=>$event->message_body
        ]);
        Http::get('https://api.mobireach.com.bd/SendTextMessage?Username=doortodoor&Password=Dhaka@1234&From=adreach&To='.$event->sent_to.'&Message='.$event->message_body)->body();
    }
}
