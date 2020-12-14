<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detsalida extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detsalidas';
    protected $hidden = ['created_at','updated_at'];

    public function prod(){
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }
}
