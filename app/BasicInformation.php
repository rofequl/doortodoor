<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicInformation extends Model
{
    protected $fillable = ['website_title','company_name','meet_time','phone_number_one','phone_number_two','email','website_link','facebook_link','twiter_link','google_plus_link','linkedin_link','footer_text','address','company_logo','status'];

}
