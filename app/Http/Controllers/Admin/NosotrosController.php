<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Nosotro;

class NosotrosController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getHome(){
    	$nos = Nosotro::find('1');
    	$data = [
            'nos'=>$nos
        ];
    	return view('admin.nosotros.home', $data);
    }

    public function postHome(Request $request){
    	$c = Nosotro::find('1');
		$c->telefono = Str::upper(e($request->input('telefono')));
        $c->contacto = Str::upper(e($request->input('contacto')));
        $c->descorta = e($request->input('descorta'));
        $c->quiesomos = e($request->input('quiesomos')); 
		if($c->save()):
			return redirect('/admin')->with('message', 'Registro guardado')->with('typealert', 'success');
		endif;
    }
}
