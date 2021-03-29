<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Nosotro;
use App\Http\Models\Especialidad;
use App\Http\Models\Sede;
use App\Http\Models\Noticia;

class NoticiaController extends Controller
{
    public function getHome(){
    	$not = Noticia::where('activo','1')->orderBy('orden')->paginate(6);
    	$nos = Nosotro::find('1');
    	$esp = Especialidad::where('activo','1')->get();
        $sed = Sede::where('activo','1')->get();
    	$data = [
    		'not'=>$not,
            'nos'=>$nos,
            'esp'=>$esp,
            'sed'=>$sed
        ];
    	return view('noticia', $data);
    }

    public function getViewNoticia($id)
    {
    	$noticia = Noticia::find($id);
    	$not = Noticia::where('activo','1')->orderBy('orden')->paginate(4);
    	$esp = Especialidad::where('activo','1')->get();
    	$nos = Nosotro::find('1');
        $sed = Sede::where('activo','1')->get();
    	$data = [
    		'noticia'=>$noticia,
    		'not'=>$not,
            'esp'=>$esp,
            'nos'=>$nos,
            'sed'=>$sed
        ];
    	return view('vnoticia', $data);
    }
}
