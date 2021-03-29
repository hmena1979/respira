<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nosotro extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'nosotros';
    protected $hidden = ['created_at','updated_at'];
}
