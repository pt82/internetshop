<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
//    protected $primaryKey='id'; // ключевое поле
    protected $table='categories'; // имя таблицы с которой работает ORM Eloquent
    protected $fillable = ['category', 'created_at', 'updated_at','photo']; // поля, в которые мы можем заносить значения
}
