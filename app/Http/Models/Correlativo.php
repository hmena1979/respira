<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Correlativo extends Model
{
    protected $dates = ['deteted_at'];
    protected $table = 'correlativos';
    protected $hidden = ['created_at','updated_at'];
}
