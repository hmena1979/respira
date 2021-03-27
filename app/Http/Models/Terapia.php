<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terapia extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'terapias';
    protected $hidden = ['created_at','updated_at'];

    public function pac(){
        return $this->hasOne(Paciente::class, 'id', 'paciente_id');
    }
}
