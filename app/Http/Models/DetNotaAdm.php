<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetNotaAdm extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'det_nota_adms';
    protected $hidden = ['created_at','updated_at'];
}
