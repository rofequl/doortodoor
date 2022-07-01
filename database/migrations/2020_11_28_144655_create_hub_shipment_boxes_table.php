<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubShipmentBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hub_shipment_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('bulk_id');
            $table->unsignedBigInteger('hub_id');
            // $table->unsignedBigInteger('shipment_id');
            $table->string('shipment_ids');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('box_by')->nullable();
            $table->string('status')->default('dispatch');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->foreign('box_by')->references('id')->on('hubs');
            // $table->foreign('shipment_id')->references('id')->on('shipments');
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
        Schema::dropIfExists('hub_shipment_boxes');
    }
}
