<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    protected $fillable = ['name','zone_id','status'];
    // relation 
    public function employees()
    {
    	return $this->hasMany(Employee::class);
    }
    
    function zone(){
    	return $this->belongsTo(Zone::class);
    }

    function shipments(){
    	return $this->belongsToMany(Shipment::class);
    }

    function admins(){
        return $this->belongsToMany(Admin::class);
    }
}
