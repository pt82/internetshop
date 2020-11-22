<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusRing extends Model
{
    protected $table='status_rings';
    protected $fillable = [ 'status'];
}
