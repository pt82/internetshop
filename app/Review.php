<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table='reviews';
    protected $fillable = [
        'id,', 'id_tovars',  'review', 'reviewgood', 'reviewbad', 'rating'
    ];

//    public function tovars()
//    {
//        return $this->hasMany(Tovar::class, 'id', );
//    }
}
