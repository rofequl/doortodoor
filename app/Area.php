<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','zone_id','hub_id','status'];

    // relation 
    function shipments(){
    	return $this->hasMany(Shipment::class);
    }

    function users(){
    	return $this->hasMany(User::class);
    }

    function zone(){
    	return $this->belongsTo(Zone::class);
    }

    function hub(){
    	return $this->belongsTo(Hub::class);
    }
}
