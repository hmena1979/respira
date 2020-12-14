<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'facturas';
    protected $hidden = ['created_at','updated_at'];

    public function cli()
    {
    	return $this->hasOne(Paciente::class, 'numdoc', 'ruc');
    }

    public function sta()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'status')->where('modulo',14);
    }

    public function mon()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'moneda')->where('modulo',10);
    }

    public function det(){
        return $this->hasMany(Detfactura::class);
    }

    public function fp()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'fpago_id')->where('modulo',11);
    }

    public function dr()
    {
    	return $this->hasOne(Doctor::class, 'id', 'doctor_id')->orderBy('nombre');
    }
}
