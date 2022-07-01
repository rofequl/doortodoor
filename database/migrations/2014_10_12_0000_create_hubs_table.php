<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('zone_id');
            $table->boolean('status')->default(1);
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->timestamps();
        });
        // \App\Hub::create([ 'name' =>'Hub one','zone_id'=>1]);
        // \App\Hub::create([ 'name' =>'Hub two','zone_id'=>2]);
        // \App\Hub::create([ 'name' =>'Hub three','zone_id'=>3]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hubs');
    }
}
