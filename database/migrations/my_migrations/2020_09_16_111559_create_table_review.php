<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tovarid')->unsigned();
            $table->foreign('tovarid')->references('id')->on('tovars');
            $table->integer('usersid')->unsigned()->nullable();
            $table->foreign('usersid')->references('id')->on('users');
            $table->string('review')->nullable();
            $table->string('reviewgood')->nullable();
            $table->string('reviewbad')->nullable();
            $table->integer('rating')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
