<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $dates = ['deteted_at'];
    protected $table = 'saldos';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['periodo','producto_id','inicial','saldo','precio'];
}
