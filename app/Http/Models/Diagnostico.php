<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'diagnosticos';
    protected $hidden = ['created_at','updated_at'];

    public function cie()
    {
    	return $this->hasOne(Cie10::class, 'codigo', 'cie10_id');
    }

    public function tip()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'tipo_id')->where('modulo',5);
    }

    public function vis()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'visita_id')->where('modulo',6);
    }
}
