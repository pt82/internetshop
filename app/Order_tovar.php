<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_tovar extends Model
{
    protected $table='order_tovar';
    protected $fillable = [
        'id',
       ' id_orders',
        'id_tovars',
        'quantity',
    ];
}
