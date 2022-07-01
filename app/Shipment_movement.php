<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment_movement extends Model
{
    protected $fillable = ['shipment_id','user_type','user_id','report_type','note','status'];

    // relation 
    function shipment(){
    	return $this->belongsTo(Shipment::class);
    }
}
