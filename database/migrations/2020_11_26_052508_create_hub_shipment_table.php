<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hub_shipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('hub_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('status')->default('on-dispatch');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shipment_id')->references('id')->on('shipments');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hub_shipment');
    }
}
