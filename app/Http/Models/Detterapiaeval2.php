<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detterapiaeval2 extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detterapiaeval2s';
    protected $hidden = ['created_at','updated_at'];
}
