<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTovarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tovar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderid')->unsigned();
            $table->foreign('orderid')->references('id')->on('orders');
            $table->integer('tovarid')->unsigned();
            $table->foreign('tovarid')->references('id')->on('tovars');
            $table->integer('quantity');
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
        Schema::table('order_tovar', function (Blueprint $table) {
            $table->dropForeign('order_tovar_orderid_foreign');
            $table->dropForeign('order_tovar_tovarid_foreign');
        });
        Schema::dropIfExists('order_tovar');
    }
}
