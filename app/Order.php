<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   // protected $guarded = [];
    protected $table='orders';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'article',
        'id_statusorders',
        'id_receives',
        'id_users',
        'receive',
        'adress',
        'day_receive',
        'time_receiveon',
        'time_receiveoff'

    ];

    public function tovars()
    {
        return $this->belongsToMany(Tovar::class, 'order_tovar', 'id_orders', 'id_tovars')->withPivot('id')->withPivot('quantity');
    }


}
