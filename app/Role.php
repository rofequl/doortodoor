<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =['title'];

    // relation 
    function admins(){
    	return $this->hasMany(Admin::class);
    }
}
