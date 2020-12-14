<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'categorias';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['modulo','nombre','codigo'];
}
