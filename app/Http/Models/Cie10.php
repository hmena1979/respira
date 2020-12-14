<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cie10 extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'cie10s';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['codigo', 'nombre'];

    public static function bus_codigo($codigo)
    {
    	return Cie10::where('codigo',$codigo)->value('nombre');
    }
}
