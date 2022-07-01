<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_verification extends Model
{
    
    protected $fillable = [ 'user_id', 'verification_code', 'status'];


    function user(){
    	return $this->belongsTo(User::class);
    }

}
