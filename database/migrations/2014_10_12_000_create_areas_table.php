<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('hub_id');
       
            $table->boolean('status')->default(1);

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->timestamps();
        });

        // \App\Area::create([ 'name' =>'Mirpur','zone_id'=>1,'hub_id'=>'1']);
        // \App\Area::create([ 'name' =>'Uttara','zone_id'=>2,'hub_id'=>'2']);
        // \App\Area::create([ 'name' =>'Kaliayour','zone_id'=>3,'hub_id'=>'3']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
