<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_review extends Model
{
    protected $fillable = ['commenter','photo','comment','status'];
}
