<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

          
            $table->integer('id_users')->unsigned();
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->integer('id_statusorders')->unsigned();
            $table->foreign('id_statusorders')->references('id')->on('statusorders')->onDelete('cascade');
            $table->integer('id_receives')->unsigned();
            $table->foreign('id_receives')->references('id')->on('receives')->onDelete('cascade');

            $table->string('article')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('receive');
            $table->string('adress');
            $table->date('day_receive');
            $table->time('time_receiveon');
            $table->time('time_receiveoff');

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
        Schema::dropIfExists('orders');
    }
}
