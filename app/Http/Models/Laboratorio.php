<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratorio extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'laboratorios';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['nombre', 'codant'];
}
