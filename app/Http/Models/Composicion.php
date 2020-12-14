<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Composicion extends Model
{
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'composicions';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['tipmed_id','nombre','codant'];
}
