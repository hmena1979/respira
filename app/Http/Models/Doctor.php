<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'doctors';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['codant','nombre','especialidad','cmp','rne','celular','telefono'];

    public function pac(){
        return $this->hasMany(Paciente::class)->where('tipo',1)->orderBy('razsoc');
    }
}
