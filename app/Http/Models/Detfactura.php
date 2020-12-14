<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detfactura extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detfacturas';
    protected $hidden = ['created_at','updated_at'];
}
