<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Servicio;

class ServicioController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getServicioHome()
    {
        return view('admin.servicios.home');
    }

    public function getServicioRegistro()
    {
        return datatables()
            ->eloquent(Servicio::query()->orderBy('nombre','Asc'))
            ->addColumn('btn','admin.servicios.action')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function getServicioAdd()
    {
        return view('admin.servicios.add');
    }

    public function postServicioAdd(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'precio' => 'required|numeric'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'precio.required' => 'Ingrese Nombre.',
    		'precio.numeric' => 'Ingrese solo números.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$s = new Servicio;
            $s->nombre = Str::upper(e($request->input('nombre')));
            $s->precio = e($request->input('precio'));
            $s->clinica = e($request->input('clinica'));
            $s->especialista = e($request->input('especialista'));
            $s->codant = e($request->input('codant'));
    		if($s->save()):
    			return redirect('/admin/servicios')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getServicioEdit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $data = [
            'servicio' => $servicio
        ];
        return view('admin.servicios.edit',$data);
    }

    public function postServicioEdit(Request $request, $id)
    {
        $rules = [
            'nombre' => 'required',
            'precio' => 'required|numeric'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'precio.required' => 'Ingrese Nombre.',
    		'precio.numeric' => 'Ingrese solo números.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$s = Servicio::findOrFail($id);
            $s->nombre = Str::upper(e($request->input('nombre')));
            $s->precio = e($request->input('precio'));
            $s->clinica = e($request->input('clinica'));
            $s->especialista = e($request->input('especialista'));
            $s->codant = e($request->input('codant'));
    		if($s->save()):
    			return redirect('/admin/servicios')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getServicioDelete($id)
    {
        $s = Servicio::findOrFail($id);
        if($s->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function getServicioFind(Request $request, $bus)
    {
        if($request->ajax()){            
            $ser = Servicio::where('nombre','like','%'.$bus.'%')
                ->orderby('nombre','Asc')
                ->take(10)
                ->get();
            return response()->json($ser);
        }
    }

    public function getServicioFindId(Request $request, $bus)
    {
        if($request->ajax()){            
            $ser = Servicio::where('id',$bus)->get();
            return response()->json($ser);
        }
    }


}
