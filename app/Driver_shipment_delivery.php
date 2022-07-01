<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_shipment_delivery extends Model
{
    protected $fillable = ['driver_id','shipment_id','type','status'];
    protected $table = 'driver_shipment_delivery';

    function driver(){
        return $this->belongsTo(Driver::class);
    }

    function shipment(){
        return $this->belongsTo(Shipment::class);
    }
}
