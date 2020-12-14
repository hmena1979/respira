<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetNotaFar extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'det_nota_fars';
    protected $hidden = ['created_at','updated_at'];

    public function prod(){
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }
}
