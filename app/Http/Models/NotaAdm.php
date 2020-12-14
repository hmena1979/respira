<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaAdm extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'nota_adms';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['nombre', 'codant'];

    public function cli()
    {
    	return $this->hasOne(Paciente::class, 'numdoc', 'ruc');
    }
    
    public function dmcomp()
    {
    	return $this->hasOne(Comprobante::class, 'codigo', 'dmcomprobante_id');
    }

    public function sta()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'status')->where('modulo',14);
    }

    public function mon()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'moneda')->where('modulo',10);
    }
}
