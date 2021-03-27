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
use App\Http\Models\Vencimiento;

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

    public function getVencimientoHome()
    {
        $vencimientos = Vencimiento::join('productos','vencimientos.producto_id','productos.id')
            ->select('vencimientos.id','vencimientos.producto_id','productos.nombre', 'vencimientos.lote',
                'vencimientos.vencimiento', 'vencimientos.entradas', 'vencimientos.salidas', 'vencimientos.saldo')
            ->where('vencimientos.saldo','>',0)
            ->orderBy('productos.nombre')
            ->get();
        $data = [
            'vencimientos' => $vencimientos
        ];
        return view('admin.productos.vencimiento',$data);
    }

    public function getVencimientoEdit($id)
    {
        $vencimiento = Vencimiento::findOrFail($id);
        $producto = Producto::findOrFail($vencimiento->producto_id);
        $data = [
            'vencimiento' => $vencimiento,
            'producto' => $producto
        ];
        return view('admin.productos.vencedit',$data);
    }

    public function postVencimientoEdit(Request $request, $id)
    {
        $m = '';
        $rules = [
    		'nlote' => 'required',
    		'nvencimiento' => 'required',
    		'ncantidad' => 'required'
    	];
    	$messages = [
    		'nlote.required' => 'Ingrese nuevo Lote.',
    		'nvencimiento.required' => 'Ingrese nuevo Vencimiento.',
    		'ncantidad.required' => 'Ingrese cantidad a descontar.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $venc = Vencimiento::findOrFail($id);
            $producto = $venc->producto_id;
            $saldo = $venc->saldo;
            $nlote = Str::upper(e($request->input('nlote')));
            $nvencimiento = e($request->input('nvencimiento'));
            $ncantidad = e($request->input('ncantidad'));
            if($ncantidad > $saldo){
                return back()->with('message', 'Se ha producido un error, cantidad exede al Saldo')->with('typealert', 'danger')->withinput();
            }
            //-------------------------------------------------------------------------------------------------
            // Actualiza Vencimientos
            $v = Vencimiento::where('producto_id',$producto)->where('lote',$nlote)->get();
            if($v->count() == 0){
                $vencn = new Vencimiento;
                $vencn->producto_id = $producto;
                $vencn->lote = $nlote;
                $vencn->vencimiento = $nvencimiento;
                $vencn->entradas = $ncantidad;
                $vencn->salidas = 0;
                $vencn->saldo = $ncantidad;
                if($vencn->save()):
                    $m = $m.'Lote actualizado con exito. ';
                endif;
            }else{
                $venc = Vencimiento::where('producto_id',$producto)
                ->where('lote',$nlote)
                ->update([
                    'entradas' => $v[0]->entradas + $ncantidad,
                    'saldo' => $v[0]->saldo + $ncantidad
                ]);
                
                $m = $m.'Lote actualizado con exito. ';
            }
            $venc->salidas = $venc->salidas + $ncantidad;
            $venc->saldo = $venc->saldo - $ncantidad;
            if($venc->save()):
    			return redirect('/admin/producto/vencimiento')->with('message', 'Registro actualizado')->with('typealert', 'success');
    		endif;

            //-------------------------------------------------------------------------------------------------
        endif;


    }

}
