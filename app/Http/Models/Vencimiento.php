<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vencimiento extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'vencimientos';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['producto_id','lote','vencimiento','entradas','saldo'];
}
