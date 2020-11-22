<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statusorder extends Model
{
    protected $table='statusorders';
    protected $fillable = [ 'status'];
}
