<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category',50);
            $table->string('slug',50);
            $table->timestamps();
        });
        Schema::create('SubCategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoryid')->unsigned();
            $table->foreign('categoryid')->references('id')->on('Categories')->onDelete('cascade');
            $table->string('subcategori',50);
            $table->string('subslug',50);
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
        Schema::dropIfExists('Categories');
        Schema::dropIfExists('SubCategories');
    }
}
