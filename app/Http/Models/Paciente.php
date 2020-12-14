<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'pacientes';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'historia','tipo','tipdoc_id','numdoc','ape_pat','ape_mat','nombre1','nombre2','razsoc','fecnac','fecing',
        'sexo_id','estciv_id','ocupacion','lorigen','lresidencia','responsable','direccion','telefono',
        'email','antecedentes','alergia','tie_enfer','tenfact','doctor_id','tippac_id','codant'
    ];

    public function his(){
        return $this->hasMany(Historia::class)->orderBy('item');
    }
}
