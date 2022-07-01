<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thirdparty_shipment extends Model
{
    protected $fillable = ['shipment_id','hub_id','admin_id','status','status_in'];

    // relation 
    function shipment(){
        return $this->belongsTo(Shipment::class);
    }
    function hub(){
        return $this->belongsTo(Hub::class);
    }
    function admin(){
        return $this->belongsTo(Admin::class);
    }



}
