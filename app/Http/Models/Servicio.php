<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'servicios';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['nombre','precio','clinica','especialista','codant'];
}
