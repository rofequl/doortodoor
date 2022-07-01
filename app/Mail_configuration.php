<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail_configuration extends Model
{
    protected $fillable = ['type','username','password','send_email'];
}
