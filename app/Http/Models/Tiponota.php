<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiponota extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'tiponotas';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['comprobante_id', 'codigo','nombre'];
}
