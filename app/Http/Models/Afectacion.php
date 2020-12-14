<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afectacion extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'afectacions';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['codigo','nombre','activo'];
}
