<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'sedes';
    protected $hidden = ['created_at','updated_at'];

    public function getGaleria()
    {
    	return $this->hasMany(Sedgaleria::class, 'sede_id', 'id');

    }
}
