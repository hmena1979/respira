<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class prcovid19 extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'prcovid19s';
    protected $hidden = ['created_at','updated_at'];

    public function cli()
    {
    	return $this->hasOne(Paciente::class, 'id', 'paciente_id');
    }
}
