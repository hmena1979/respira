<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Comprobante;

class ComprobanteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getComprobanteHome()
    {
        $comprobantes = Comprobante::get();
        $data = [
            'comprobantes'=>$comprobantes
        ];
        return view('admin.comprobantes.home', $data);
    }

    public function getComprobanteAdd()
    {
        return view('admin.comprobantes.add');
    }

    public function postComprobanteAdd(Request $request)
    {
        $rules = [
            'codigo' => 'required',
    		'nombre' => 'required'
    	];
    	$messages = [
    		'codigo.required' => 'Ingrese código.',
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $c = new Comprobante;
            $c->codigo = Str::upper(e($request->input('codigo')));
            $c->nombre = Str::upper(e($request->input('nombre')));
            $c->sigla = Str::upper(e($request->input('sigla')));
            $c->activo = e($request->input('activo'));

    		if($c->save()):
    			return redirect('/admin/comprobantes')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getComprobanteEdit($id)
    {
        $comprobante = Comprobante::findOrFail($id);
        $data = [
            'comprobante'=>$comprobante
        ];
        return view('admin.comprobantes.edit', $data);
    }

    public function postComprobanteEdit(Request $request, $id)
    {
        $rules = [
            'codigo' => 'required',
    		'nombre' => 'required'
    	];
    	$messages = [
    		'codigo.required' => 'Ingrese código.',
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $c = Comprobante::findOrFail($id);
            $c->codigo = Str::upper(e($request->input('codigo')));
            $c->nombre = Str::upper(e($request->input('nombre')));
            $c->sigla = Str::upper(e($request->input('sigla')));
            $c->activo = e($request->input('activo'));

    		if($c->save()):
    			return redirect('/admin/comprobantes')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getComprobanteDelete($id)
    {
        $u = Comprobante::findOrFail($id);
        if($u->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }
}
