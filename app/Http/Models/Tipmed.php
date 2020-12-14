<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipmed extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'tipmeds';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['nombre', 'codant'];

    public function comp(){
        return $this->hasMany(Composicion::class);
    }
}
