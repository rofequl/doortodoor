<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    protected $fillable =['zone_id','cod','cod_value','delivery_type','max_weight','max_price','per_weight','price'];

    function zone(){
    	return $this->belongsTo(Zone::class);
    }
}
