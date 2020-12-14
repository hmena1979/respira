<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Umedida;

class UMedidaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getUMedidaHome()
    {
        $umedidas = Umedida::get();
        $data = [
            'umedidas'=>$umedidas
        ];
        return view('admin.umedidas.home', $data);
    }

    
    public function getUMedidaAdd()
    {
        return view('admin.umedidas.add');
    }

    public function postUMedidaAdd(Request $request)
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
    		$u = new Umedida;
            $u->nombre = Str::upper(e($request->input('nombre')));
            $u->codant = Str::upper(e($request->input('codant')));
            $u->sunat = Str::upper(e($request->input('sunat')));

    		if($u->save()):
    			return redirect('/admin/umedidas')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getUMedidaEdit($id)
    {
        $umedida = Umedida::findOrFail($id);
        $data = [
            'umedida'=>$umedida
        ];
        return view('admin.umedidas.edit', $data);
    }

    public function postUMedidaEdit(Request $request, $id)
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
    		$u = Umedida::findOrFail($id);
            $u->nombre = Str::upper(e($request->input('nombre')));
            $u->codant = Str::upper(e($request->input('codant')));
            $u->sunat = Str::upper(e($request->input('sunat')));

    		if($u->save()):
    			return redirect('/admin/umedidas')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getUMedidaDelete($id)
    {
        $u = Umedida::findOrFail($id);
        if($u->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }
}
