<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Producto;
use App\Http\Models\Tipmed;
use App\Http\Models\Composicion;
use App\Http\Models\Umedida;
use App\Http\Models\Laboratorio;
use App\Http\Models\Detingreso;
use App\Http\Models\Detsalida;

class ProductoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getProductoHome()
    {
        $productos = Producto::with(['umedida'])
            ->select('id','nombre','umedida_id','stock','premerca')
            ->get();
        $data = [
            'productos' => $productos
        ];
        return view('admin.productos.home',$data);
    }

    public function getProductoAdd(){
        $tipmed = Tipmed::orderBy('nombre')->pluck('nombre','id');
        // $composicion = Composicion::orderBy('nombre')->pluck('nombre','id');
        $composicion = [];
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $laboratorio = Laboratorio::orderBy('nombre')->pluck('nombre','id');
        $data = [
            'tipmed' => $tipmed,
            'composicion' => $composicion,
            'umedida' => $umedida,
            'laboratorio' => $laboratorio
        ];
        return view('admin.productos.add',$data);
    }

    public function postProductoAdd(Request $request)
    {
        $rules = [
    		'nombre' => 'required',
    		'tipmed_id' => 'required',
    		'composicion_id' => 'required',
    		'umedida_id' => 'required',
    		'afecto' => 'required',
    		'laboratorio_id' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'tipmed_id.required' => 'Ingrese tipo de medicamento.',
    		'composicion_id.required' => 'Ingrese composición.',
    		'umedida_id.required' => 'Ingrese presentación.',
    		'afecto.required' => 'Ingrese afectación.',
    		'laboratorio_id.required' => 'Ingrese laboratorio.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$doctor = new Producto;
    		$doctor->nombre = Str::upper(e($request->input('nombre')));
            $doctor->tipmed_id = e($request->input('tipmed_id'));
            $doctor->composicion_id = e($request->input('composicion_id'));
            $doctor->umedida_id = e($request->input('umedida_id'));
            $doctor->stockmin = e($request->input('stockmin'));
            $doctor->afecto = e($request->input('afecto'));
            $doctor->laboratorio_id = e($request->input('laboratorio_id'));
            $doctor->premerca = e($request->input('premerca'));
            $doctor->porganancia = e($request->input('porganancia'));
            $doctor->codant = $request->input('codant');

    		if($doctor->save()):
    			return redirect('/admin/productos/')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getProductoEdit($id){
        $producto = Producto::findOrFail($id);
        $tipmed = Tipmed::orderBy('nombre')->pluck('nombre','id');
        $composicion = Composicion::where('tipmed_id',$producto->tipmed_id)->orderBy('nombre')->pluck('nombre','id');
        //$composicion = [];
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $laboratorio = Laboratorio::orderBy('nombre')->pluck('nombre','id');
        $data = [
            'producto' => $producto,
            'tipmed' => $tipmed,
            'composicion' => $composicion,
            'umedida' => $umedida,
            'laboratorio' => $laboratorio
        ];
        return view('admin.productos.edit',$data);
    }

    public function postProductoEdit(Request $request, $id)
    {
        $rules = [
    		'nombre' => 'required',
    		'tipmed_id' => 'required',
    		'composicion_id' => 'required',
    		'umedida_id' => 'required',
    		'afecto' => 'required',
    		'laboratorio_id' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'tipmed_id.required' => 'Ingrese tipo de medicamento.',
    		'composicion_id.required' => 'Ingrese composición.',
    		'umedida_id.required' => 'Ingrese presentación.',
    		'afecto.required' => 'Ingrese afectación.',
    		'laboratorio_id.required' => 'Ingrese laboratorio.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$doctor = Producto::findOrFail($id);
    		$doctor->nombre = Str::upper(e($request->input('nombre')));
            $doctor->tipmed_id = e($request->input('tipmed_id'));
            $doctor->composicion_id = e($request->input('composicion_id'));
            $doctor->umedida_id = e($request->input('umedida_id'));
            $doctor->stockmin = e($request->input('stockmin'));
            $doctor->afecto = e($request->input('afecto'));
            $doctor->laboratorio_id = e($request->input('laboratorio_id'));
            $doctor->premerca = e($request->input('premerca'));
            $doctor->porganancia = e($request->input('porganancia'));
            $doctor->codant = $request->input('codant');

    		if($doctor->save()):
    			return redirect('/admin/productos/')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getProductoDelete($id){
        $c = Producto::findOrFail($id);
        $ti = Detingreso::where('producto_id',$id)->count();
        $ts = Detsalida::where('producto_id',$id)->count();
        if($ti > 0 || $ts > 0){
            return back()->with('message', 'El registro no puede ser eliminado, ya se realizó operaciones')->with('typealert', 'danger');
        }else{
            if($c->delete()):
                return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
            endif;
        }
    	
    }

    public function getProductoRegistro()
    {
        return datatables()
            ->eloquent(Producto::get())
            ->addColumn('btn','admin.cie10s.action')
            ->rawColumns(['btn'])
            ->toJson();
        //return DataTables::of(Cie10::query())->make(true);
        //return datatables(Cie10::all())->toJson();
    }

    public function getProductoSearch(Request $request, $bus)
    {
        if($request->ajax()){
            
            $pro = Producto::with(['composicion','umedida'])
                ->join('composicions','productos.composicion_id','composicions.id')
                ->where('productos.nombre','like','%'.$bus.'%')
                ->orWhere('composicions.nombre','like','%'.$bus.'%')
                ->select('productos.*')
                ->take(10)
                ->get();
            return response()->json($pro);
        }
    }

    public function getProductoSearchId(Request $request, $bus)
    {
        if($request->ajax()){
            $pro = Producto::with(['composicion'])->where('id',$bus)->get();
            //$pro = Producto::findOrFail($bus);
            return response()->json($pro);
        }
    }

}
