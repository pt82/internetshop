<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ring extends Model
{
    protected $table='rings';
    protected $fillable = [
        'id,', 'id_stattus_rings',  'name', 'phone', 'coment'
    ];
}
