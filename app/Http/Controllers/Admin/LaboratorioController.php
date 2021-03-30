<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Laboratorio;

class LaboratorioController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getLaboratorioHome()
    {
        $laboratorios = Laboratorio::get();
        $data = [
            'laboratorios'=>$laboratorios
        ];
        return view('admin.laboratorios.home', $data);
    }

    
    public function getLaboratorioAdd()
    {
        return view('admin.laboratorios.add');
    }

    public function postLaboratorioAdd(Request $request)
    {
        $rules = [
    		'nombre' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$u = new Laboratorio;
            $u->nombre = Str::upper(e($request->input('nombre')));
            $u->codant = Str::upper(e($request->input('codant')));

    		if($u->save()):
    			return redirect('/admin/laboratorios')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getLaboratorioEdit($id)
    {
        $laboratorio = Laboratorio::findOrFail($id);
        $data = [
            'laboratorio'=>$laboratorio
        ];
        return view('admin.laboratorios.edit', $data);
    }

    public function postLaboratorioEdit(Request $request, $id)
    {
        $rules = [
    		'nombre' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$u = Laboratorio::findOrFail($id);
            $u->nombre = Str::upper(e($request->input('nombre')));
            $u->codant = Str::upper(e($request->input('codant')));

    		if($u->save()):
    			return redirect('/admin/laboratorios')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getLaboratorioDelete($id)
    {
        $u = Laboratorio::findOrFail($id);
        if($u->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }
}
