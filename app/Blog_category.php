<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog_category extends Model
{
    protected $fillable = [	'name','photo','status'];


    function blogs(){
    	return $this->hasMany(Blog::class);
    }
}
