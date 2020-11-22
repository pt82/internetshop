<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TovarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tovars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoryid')->unsigned();
            $table->foreign('categoryid')->references('id')->on('Categories')->onDelete('cascade');
            $table->integer('subcategoryid')->unsigned();
            $table->foreign('subcategoryid')->references('id')->on('subcategories')->onDelete('cascade');

            $table->string('name',50);
            $table->string('desc',250);
            $table->string('slug',50);
            $table->string('photo',250);
            $table->integer('pricein');
            $table->integer('priceout');
            $table->integer('balance');
            $table->float('rating');
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
        Schema::dropIfExists('tovars');
    }
}
