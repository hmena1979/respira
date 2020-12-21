<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetModreceta extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'det_modrecetas';
    protected $hidden = ['created_at','updated_at'];

    public function pro()
    {
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function um()
    {
        return $this->hasOne(Umedida::class, 'id', 'umedida_id');
    }

    public function pmed()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'posmed_id')->where('modulo',7)->orWhere('modulo',12);
    }

    public function pfre()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'posfrec_id')->where('modulo',8)->orWhere('modulo',12);
    }

    public function ptie()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'postie_id')->where('modulo',9)->orWhere('modulo',12);
    }
}
