<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sedgaleria extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'sedgalerias';
    protected $hidden = ['created_at','updated_at'];
}
