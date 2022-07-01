<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverHubShipmentBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_hub_shipment_box', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('hub_shipment_box_id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('status')->default('pending');
            $table->string('status_in')->nullable();
            $table->string('driver_note')->nullable();

            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('hub_shipment_box_id')->references('id')->on('hub_shipment_boxes');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('shipment_id')->references('id')->on('shipments');
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
        Schema::dropIfExists('driver_hub_shipment_box');
    }
}
