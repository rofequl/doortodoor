<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('shop_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('website_link')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['0','1'])->default(1);
            $table->enum('is_verified',['0','1'])->default(0);
            $table->rememberToken();

            $table->foreign('area_id')->references('id')->on('areas');
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
        Schema::dropIfExists('users');
    }
}
