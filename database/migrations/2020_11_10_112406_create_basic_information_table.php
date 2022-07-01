<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\BasicInformation;
class CreateBasicInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_information', function (Blueprint $table) {
            $table->id();
            $table->string('website_title')->nullable();
            $table->string('company_name')->nullable();
            $table->string('meet_time')->nullable();
            $table->string('phone_number_one')->nullable();
            $table->string('phone_number_two')->nullable();
            $table->string('email')->nullable();
            $table->string('website_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twiter_link')->nullable();
            $table->string('google_plus_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('address')->nullable();
            $table->string('company_logo')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        BasicInformation::create([
            'website_title'=>'Door to Door Express Delivery',
            'company_name'=>'Door to Door Express Delivery',
            'meet_time'=>'SAT- FRIDAY. 7AM-10PM',
            'phone_number_one'=>'01724904126',
            'phone_number_two'=>'01724904126',
            'address'=>'MIRPUR 6, ROAD NO- 8,BLOCK- D,HOUSE NO- 18,POSTAL CODE - 1216,DHAKA',
            'company_logo'=>'951605127025.png',
            'status'=>1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_information');
    }
}
