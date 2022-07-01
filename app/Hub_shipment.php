<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hub_shipment extends Model
{
    protected $fillable = ['user_id','shipment_id','hub_id','admin_id','status'];
    protected $table = 'hub_shipment';

    // relation 
    function shipment(){
    	return $this->belongsTo(Shipment::class);
    }
   	
   	function hub(){
    	return $this->belongsTo(Hub::class);
    }

    function user(){
    	return $this->belongsTo(User::class);
    }

    function admin(){
    	return $this->belongsTo(Admin::class);
    }

}
