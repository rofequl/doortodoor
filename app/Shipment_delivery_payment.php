<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment_delivery_payment extends Model
{
    protected $fillable = ['shipment_id','admin_id','amount'];

    // relation 
    function user(){
        return $this->belongsTo(User::class);
    }

    function shipment(){
        return $this->belongsTo(Shipment::class);
    }

    function admin(){
        return $this->belongsTo(Admin::class);
    }

}
