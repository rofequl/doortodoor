<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_shipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('admin_id');
            $table->text('note')->nullable();
            $table->enum('status',['pending','delivered','lost','received','cancelled'])->default('pending');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('shipment_id')->references('id')->on('shipments');
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
        Schema::dropIfExists('driver_shipment');
    }
}
