<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'productos';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['nombre','codant','tipmed_id','umedida_id',
        'stock','stockmin','precompra','afecto','composicion_id','laboratorio_id','premerca','porganancia'];
    
    public function composicion()
    {
        return $this->hasOne(Composicion::class, 'id', 'composicion_id');
    }

    public function umedida()
    {
        return $this->hasOne(Umedida::class, 'id', 'umedida_id');
    }

    public static function bus_tabla($bus)
    {
        
        //->where('nombre','like','%'.$bus.'%')
        $cb = function($query){
            $query->where('nombre','like','%'.$bus.'%');
        };
        $pro = Producto::with(['composicion','umedida'])
        ->orderby('nombre','Asc')->take(10)->get();
    	return $pro;
    }
}
