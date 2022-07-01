<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Driver extends Authenticatable
{
    use Notifiable;

    protected $guard = 'driver';

    protected $fillable = [
        'driver_id','first_name','last_name', 'email','phone', 'password','image','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // relation 
    public function hub_shipment_boxes()
    {
    	return $this->belongsToMany(Hub_shipment_box::class);
    }
    
}
