<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin_hub extends Model
{
    protected $table = 'admin_hub';
    protected $fillable = ['admin_id','hub_id'];

    function admin(){
    	return $this->belongsTo(Admin::class);
    }

    function hub(){
    	return $this->belongsTo(Hub::class);
    }

}
