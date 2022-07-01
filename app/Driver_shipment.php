<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_shipment extends Model
{
    protected $fillable = ['driver_id','shipment_id','admin_id','note','status'];
    protected $table = 'driver_shipment';

    // relation 
    function driver(){
    	return $this->belongsTo(Driver::class);
    }

    function shipment(){
    	return $this->belongsTo(Shipment::class);
    }

    function admin(){
    	return $this->belongsTo(Admin::class);
    }
}
