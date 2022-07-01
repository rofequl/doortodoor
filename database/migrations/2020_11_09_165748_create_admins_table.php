<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('hub_id')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();;

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->timestamps();
        });

        \App\Admin::create([
            'role_id' => '1', 'first_name' => 'admin',
            'last_name' => 'name','email' => 'admin@email.com',
            'phone' => '01749015457', 'password' => Hash::make('12345678'),
            'address' => 'savar'
        ]);

        \App\Admin::create([
            'role_id' => '2', 'first_name' => 'sub',
            'last_name' => 'admin','email' => 'sub-admin@email.com',
            'phone' => '588887656', 'password' => Hash::make('12345678'),
            'address' => 'savar, dhakak'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
