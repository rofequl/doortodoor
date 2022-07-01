<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_shipment extends Model
{
    protected $fillable = ['shipment_id','hub_id','admin_id','status'];

    function admin(){
        return $this->belongsTo(Admin::class);
    }
    function shipment(){
        return $this->belongsTo(Shipment::class);
    }

    function hub(){
        return $this->belongsTo(Hub::class);
    }
}
