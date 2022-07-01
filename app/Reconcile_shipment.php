<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reconcile_shipment extends Model
{
    protected $fillable =['shipment_id','admin_id','loops','status'];

    // relation 
    function shipment(){
    	return $this->belongsTo(Shipment::class);
    }
}
