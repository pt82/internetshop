<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table='events';
    protected $fillable = [ 'event_name','image','link','data_begin', 'data_end', 'active'];
}
