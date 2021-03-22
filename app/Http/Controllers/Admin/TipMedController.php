<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator, Str;

use App\Http\Models\Tipmed;
use App\Http\Models\Composicion;
use App\Http\Models\Producto;

class TipMedController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getTipMedHome($id)
    {
        $tipmeds = Tipmed::orderBy('nombre')->get();
        $Composicions = Composicion::where('tipmed_id', $id)->orderBy('nombre','Asc')->get();
        $data = [
            'tipmeds' => $tipmeds,
            'Composicions' => $Composicions,
            'id' => $id
        ];
    	return view('admin.tipmeds.home', $data);
    }

    public function getTipMedSelComposicion(Request $request, $id)
    {
        if($request->ajax()){
    		$ddes = Composicion::where('tipmed_id',$id)->orderBy('nombre','Asc')->get();
    		return response()->json($ddes);
    	}
    }

    public function getTipMedAdd()
    {
        return view('admin.tipmeds.add');
    }

    public function postTipMedAdd(Request $request)
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
    		$u = new Tipmed;
            $u->nombre = Str::upper(e($request->input('nombre')));

    		if($u->save()):
    			return redirect('/admin/tipmeds/'.$u->id)->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getTipMedEdit($id)
    {
        $tipmed = Tipmed::findOrFail($id);
        $data = [
            'tipmed'=>$tipmed
        ];
        return view('admin.tipmeds.edit', $data);
    }

    public function postTipMedEdit(Request $request, $id)
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
    		$u = Tipmed::findOrFail($id);
            $u->nombre = Str::upper(e($request->input('nombre')));

    		if($u->save()):
    			return redirect('/admin/tipmeds/'.$u->id)->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getTipMedAddComposicion($id)
    {
        $tipmed = Tipmed::findOrFail($id);
        $data = [
            'tipmed'=>$tipmed
        ];
        return view('admin.tipmeds.addcomposicion', $data);
    }

    public function postTipMedAddComposicion(Request $request, $id)
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
    		$u = new Composicion;
            $u->tipmed_id = $id;
            $u->nombre = Str::upper(e($request->input('nombre')));

    		if($u->save()):
    			return redirect('/admin/tipmeds/'.$id)->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getTipMedEditComposicion($id)
    {
        $composicion = Composicion::findOrFail($id);
        $tipmed = Tipmed::findOrFail($composicion->tipmed_id);
        $data = [
            'tipmed'=>$tipmed,
            'composicion' => $composicion
        ];
        return view('admin.tipmeds.editcomposicion', $data);
    }

    public function postTipMedEditComposicion(Request $request, $id)
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
    		$u = Composicion::findOrFail($id);
            $u->nombre = Str::upper(e($request->input('nombre')));

    		if($u->save()):
    			return redirect('/admin/tipmeds/'.$u->tipmed_id)->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getTipMedDeleteComposicion($id)
    {
        $u = Composicion::findOrFail($id);
        $p = Producto::where('composicion_id',$id)->count();
        if($p > 0){
            return back()->with('message', 'No se puede eliminar, registro contenido en productos')->with('typealert', 'danger')->withinput();
        }
        if($u->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

}
