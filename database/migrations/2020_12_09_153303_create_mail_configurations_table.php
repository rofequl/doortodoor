<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mail_configuration;
class CreateMailConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('default: config');
            $table->string('username');
            $table->string('password');
            $table->string('send_email')->comment('referrece email to send mail');
            $table->timestamps();
        });
        Mail_configuration::create([
            'type'=>'config',
            'username'=>'knockme18@gmial.com',
            'password'=>'password',
            'send_email'=>'info.n121@gmail.com'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_configurations');
    }
}
