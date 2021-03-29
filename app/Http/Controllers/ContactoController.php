<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Nosotro;
use App\Http\Models\Especialidad;
use App\Http\Models\Servicio;
use App\Http\Models\Sede;
use App\Http\Models\Contacto;

class ContactoController extends Controller
{
    public function getContacto()
    {
        $sed = Sede::where('activo','1')->get();
        $nos = Nosotro::find('1');
        $esp = Especialidad::where('activo','1')->get();
        $data = [
            'sed'=>$sed,
            'nos'=>$nos,
            'esp'=>$esp    
        ];
        return view('contacto', $data);
    }

    public function postContacto(Request $request){
    	$rules = [
    		'nombre' => 'required',
    		'telef' => 'required',
    		'asunto' => 'required',
    		'contenido' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese apellidos y Nombre.',
    		'telef.required' => 'Ingrese teléfono',
    		'asunto.required' => 'Ingrese asunto',
    		'contenido.required' => 'Ingrese descripción'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Ingrese información obligatoria')->with('typealert', 'danger')->withinput();
    	else:
	        $c = new Contacto;
	        $c->nombre = e($request->input('nombre'));
	        $c->fecha = date('Y-m-d');
	        $c->telef = e($request->input('telef'));
	        $c->email = e($request->input('email'));
	        $c->asunto = e($request->input('asunto'));
	        $c->contenido = e($request->input('contenido'));
	        $c->activo = 1;
	        if($c->save()):
	            return back()->with('message', 'Consulta enviada')->with('typealert', 'success');
	        endif;
	    endif;

    }
}
