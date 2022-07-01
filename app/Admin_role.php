<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin_role extends Model
{
    protected $fillable = ['admin_id','route'];

    function admin(){
        return $this->belongsTo(Admin::class);
    }
}
