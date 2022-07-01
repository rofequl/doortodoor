<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [	'admin_id','blog_category_id','title','photo','description','status'];


    function blog_category(){
    	return $this->belongsTo(Blog_category::class);
    }

    function admin(){
    	return $this->belongsTo(Admin::class);
    }
}
