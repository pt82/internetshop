<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableCreateRings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_status_rings')->unsigned();
            $table->foreign('id_status_rings')->references('id')->on('status_rings')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('coment')->nullable();
            $table->integer('phone')->nullable();
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
        Schema::dropIfExists('rings');
    }
}
