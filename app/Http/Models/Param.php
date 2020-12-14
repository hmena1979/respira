<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $dates = ['deteted_at'];
    protected $table = 'params';
    protected $hidden = ['created_at','updated_at'];
}
