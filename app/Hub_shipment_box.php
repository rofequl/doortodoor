<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hub_shipment_box extends Model
{
    protected $fillable = ['bulk_id','hub_id','shipment_ids','admin_id','box_by','status'];

    function hub(){
    	return $this->belongsTo(Hub::class);
    }
    function admin(){
    	return $this->belongsTo(Admin::class);
    }

    function box_by(){
    	return $this->belongsTo(Hub::class,'id');
    }

    function drivers(){
    	return $this->belongsToMany(Driver::class);
    }
}
