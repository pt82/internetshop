<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Tovar extends Model
{
  //  use Notifiable;

    protected $table='tovars';
    protected $fillable = [
         'id,', 'id_categories', 'id_subcategories', 'article', 'name', 'desc', 'slug',  'pricein', 'priceout', 'balance', 'photo', 'rating'
    ];
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


}
