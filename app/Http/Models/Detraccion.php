<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detraccion extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detraccions';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['codigo','nombre','porcentaje'];
}
