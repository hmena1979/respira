<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'ingresos';
    protected $hidden = ['created_at','updated_at'];

    public function prov(){
        return $this->hasOne(Paciente::class, 'id', 'proveedor_id');
    }
}
