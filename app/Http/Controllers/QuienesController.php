<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Nosotro;
use App\Http\Models\Especialidad;
use App\Http\Models\Sede;

class QuienesController extends Controller
{
    public function getHome(){
    	$nos = Nosotro::find('1');
    	$esp = Especialidad::where('activo','1')->get();
        $sed = Sede::where('activo','1')->get();
    	$data = [
            'nos'=>$nos,
            'esp'=>$esp,
            'sed'=>$sed
        ];
    	return view('quienes', $data);
    }
}
