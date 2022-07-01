<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['user_id','zone_id','area_id','added_by','name','phone','address','zip_code','parcel_value','invoice_id','merchant_note','weight','delivery_type','cod','cod_amount','price','tracking_code','total_price','shipping_status','status','time_starts'];

    // relationships 
    function area(){
    	return $this->belongsTo(Area::class);
    }
    function user(){
    	return $this->belongsTo(User::class);
    }
    function zone(){
    	return $this->belongsTo(Zone::class);
    }

    function hubs(){
        return $this->belongsToMany(Hub::class);
    }
}
