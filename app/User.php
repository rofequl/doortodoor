<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id', 'first_name', 'last_name','shop_name', 'email', 'phone', 'password','address','area_id','website_link','image','status','is_verified'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    function area(){
    	return $this->belongsTo(Area::class);
    }


}
