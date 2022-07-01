<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_return_shipment_box extends Model
{
    protected $fillable = ['driver_id','return_shipment_box_id','shipment_id','admin_id','status','status_in','driver_note'];
    protected $table = 'driver_return_shipment_box';
    
    function driver(){
    	return $this->belongsTo(Driver::class);
    }
    function hub_shipment_box(){
    	return $this->belongsTo(Hub_shipment_box::class);
    }
    function admin(){
    	return $this->belongsTo(Admin::class);
    }
    function shipment(){
    	return $this->belongsTo(Shipment::class);
    }


}
