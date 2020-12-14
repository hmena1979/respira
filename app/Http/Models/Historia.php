<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'historias';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['paciente_id','doctor_id','item','tipo','tippac_id','fecha','peso','talla','fc','fr','sato2','pa','anammesis','plantera','status'];

    public function pac(){
        return $this->hasOne(Paciente::class, 'id', 'paciente_id');
    }
    
    public function dr(){
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }

    public function sta()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'status')->where('modulo',4);
    }
    
    public function tip()
    {
    	return $this->hasOne(Categoria::class, 'codigo', 'tipo')->where('modulo',13);
    }
}
