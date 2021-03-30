<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\KardexController;
use Illuminate\Http\Request;
use Validator, Str, Auth;

use App\Http\Models\Ingreso;
use App\Http\Models\Detingreso;
use App\Http\Models\Producto;
use App\Http\Models\Umedida;
use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Comprobante;
use App\Http\Models\Correlativo;
use App\Http\Models\Vencimiento;
use App\Http\Models\Kardex;
use App\Http\Models\Param;


class IngresoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getIngresoHome($periodo)
    {
        $ingresos = Ingreso::with(['prov'])->where('periodo',$periodo)->get();
        $data = [
            'ingresos' => $ingresos,
            'periodo' => $periodo
        ];
        return view('admin.ingresos.home', $data);
    }

    public function postIngresoCambio(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $ingresos = Ingreso::with(['prov'])->where('periodo',$periodo)->get();
        $data = [
            'ingresos' => $ingresos,
            'periodo' => $periodo
        ];
        return view('admin.ingresos.home', $data);
    }

    public function getIngresoAdd()
    {        
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $proveedores = Paciente::orderBy('razsoc','asc')->pluck('razsoc','id');
        $data = [
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'proveedores' => $proveedores
        ];
        return view('admin.ingresos.add', $data);
    }

    public function postIngresoAdd(Request $request)
    {
        $rules = [
    		'fecha' => 'required',
    		'serie' => 'required',
    		'numero' => 'required',
    		'proveedor_id' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'serie.required' => 'Ingrese serie.',
    		'numero.required' => 'Ingrese número.',
    		'proveedor_id.required' => 'Ingrese proveedor.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $f = new Ingreso;
            $f->periodo = e($request->input('periodo'));
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            if(empty($f->cancelacion)){
                $f->cancelacion = null;
            }
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->comprobante_id = e($request->input('comprobante_id'));
            $f->serie = e($request->input('serie'));
            $f->numero = e($request->input('numero'));
            $f->proveedor_id = e($request->input('proveedor_id'));
            $f->subtotal = 0.00;
            $f->igv = 0.00;
            $f->total = 0.00;

            if($f->save()):
    			return redirect('/admin/ingreso/'.$f->id.'/deta')->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getIngresoDetAdd($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $proveedores = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $productos = Producto::orderBy('nombre','asc')->pluck('nombre','id');
        $umedida = Umedida::orderBy('nombre','asc')->pluck('nombre','id');
        $parametro = Param::findOrFail(1);
        $data = [
            'ingreso' => $ingreso,
            'comprobante' => $comprobante,
            'proveedores' => $proveedores,
            'productos' => $productos,
            'parametro' => $parametro,
            'umedida' => $umedida
        ];
        return view('admin.ingresos.deta', $data);
    }

    public function postIngresoDetAdd(Request $request, $id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $proveedor = Paciente::findOrFail($ingreso->proveedor_id);
        $rules = [
    		'producto_id' => 'required',
    		'cantidad' => 'required',
    		'pre_ini' => 'required',
    		'precio' => 'required',
    		'lote' => 'required',
    		'vence' => 'required'
    	];
    	$messages = [
    		'producto_id.required' => 'Ingrese producto.',
    		'cantidad.required' => 'Ingrese cantidad.',
    		'pre_ini.required' => 'Ingrese precio inicial.',
    		'precio.required' => 'Ingrese precio.',
    		'lote.required' => 'Ingrese lote.',
    		'vence.required' => 'Ingrese vencimiento.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $di = new Detingreso;
            $di->ingreso_id = $id;
            $di->producto_id = e($request->input('producto_id'));
            $di->afecto = e($request->input('afecto'));
            $di->igv = e($request->input('igv'));
            $di->pre_ini = e($request->input('pre_ini'));
            $di->cantidad = e($request->input('cantidad'));
            $di->precio = e($request->input('precio'));
            $di->subtotal = e($request->input('subtotal'));
            $di->vence = e($request->input('vence'));
            $di->lote = e($request->input('lote'));
            $di->glosa = Str::upper(e($request->input('glosa')));

            if($di->save()):
                $m = 'Producto agregado con exito. ';
                if($ingreso->moneda == 'PEN'){
                    $precio = $di->precio;
                }else{
                    $precio = round($di->precio * $ingreso->tc,4);
                }
                // Actualiza producto
                $p = Producto::find($di->producto_id);
                if($ingreso->comprobante_id == '07'){
                    $p->precompra = prePromE($p->stock, $p->precompra, $di->cantidad, $precio);
                    $p->stock = $p->stock - $di->cantidad;
                }else{
                    $p->precompra = preProm($p->stock, $p->precompra, $di->cantidad, $precio);
                    $p->stock = $p->stock + $di->cantidad;
                }
            	
            	if($p->save()):
            		$m = $m.'Stock de producto actualizado con exito. ';
                endif;
                // Actualiza Kardex
                $k = new Kardex;
            	$k->periodo = session('pfarmacia');
            	if($ingreso->comprobante_id == '07'){
                    $k->tipo = 4; ////(1)Ingreso (2)Consumo directo (3)Salidas (4)Nota de Credito
            	    $k->cant_ent = $di->cantidad * -1;
                }
                else{
                    $k->tipo = 1; ////(1)Ingreso (2)Consumo directo (3)Salidas (4)Nota de Credito
            	    $k->cant_ent = $di->cantidad;
                }
            	$k->operacion_id = $di->id;
            	$k->producto_id = $di->producto_id;
            	$k->cliente_id = $proveedor->id;
            	$k->documento = numDoc($ingreso->serie,$ingreso->numero);
            	$k->proveedor = $proveedor->razsoc;
            	$k->fecha = $ingreso->fecha;
            	$k->cant_sald = $p->stock;
            	$k->pre_compra = $precio;
            	$k->pre_prom = $p->precompra;
            	$k->descrip = $di->glosa;
                
            	if($k->save()):
            		$m = $m.'Kardex actualizado con exito. ';
                endif;
                // Actualiza Vencimientos
                $v = Vencimiento::where('producto_id',$di->producto_id)->where('lote',$di->lote)->get();
                if($v->count() == 0){
                    $venc = new Vencimiento;
                    $venc->producto_id = $di->producto_id;
                    $venc->lote = $di->lote;
                    $venc->vencimiento = $di->vence;
                    $venc->entradas = $di->cantidad;
                    $venc->salidas = 0;
                    $venc->saldo = $di->cantidad;
                    if($venc->save()):
                        $m = $m.'Lote actualizado con exito. ';
                    endif;
                }else{
                    if($ingreso->comprobante_id == '07'){
                        $venc = Vencimiento::where('producto_id',$di->producto_id)
                        ->where('lote',$di->lote)
                        ->update([
                            'entradas' => $v[0]->entradas - $di->cantidad,
                            'saldo' => $v[0]->saldo - $di->cantidad
                        ]);
                    }
                    else{
                        $venc = Vencimiento::where('producto_id',$di->producto_id)
                        ->where('lote',$di->lote)
                        ->update([
                            'entradas' => $v[0]->entradas + $di->cantidad,
                            'saldo' => $v[0]->saldo + $di->cantidad
                        ]);
                    }
                    
                    $m = $m.'Lote actualizado con exito. ';
                }
                //Actualiza sumatoria
                $stafecto = Detingreso::where('ingreso_id', $id)->where('afecto', 1)->sum('subtotal');
                $stinafecto = Detingreso::where('ingreso_id', $id)->where('afecto', 2)->sum('subtotal');
                $ingreso->subtotal = $stafecto + $stinafecto;
                $ingreso->igv = round($stafecto * (session('igv')/100),2);
                $ingreso->total = $ingreso->subtotal + $ingreso->igv;
                $i = $ingreso->save();
                $kardex = new KardexController();
                $b = $kardex->Regenerate(session('pfarmacia'),$di->producto_id);

    			return redirect('/admin/ingreso/'.$id.'/edit')->with('message', 'Registro guardado '.$m)->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getIngresosDetDelete($id)
    {
        $di = Detingreso::findOrFail($id);
        $ingreso_id = $di->ingreso_id;
        $ingreso = Ingreso::findOrFail($ingreso_id);
        $prod = $di->producto_id;
        $lote = $di->lote;
        $pre_ant = $di->precio;
        $can_ant = $di->cantidad;
        $p = Producto::findOrFail($prod);

        if($ingreso->comprobante_id == '07'){
            $rprecio = preProm($p->stock, $p->precio_prom, $can_ant, $pre_ant);
            $rstock = $p->stock + $can_ant;
        }
        else{
            $rprecio = prePromE($p->stock, $p->precio_prom, $can_ant, $pre_ant);
            $rstock = $p->stock - $can_ant;
        }
        
        
        if($di->delete()):
            $k = Kardex::where('operacion_id',$id)->where('tipo', 1)->delete();
            $p->stock = $rstock;
            $p->precompra = $rprecio;
            $p1 = $p->save();
            //Vencimiento
            if($ingreso->comprobante_id == '07'){
                $v = Vencimiento::where('producto_id',$prod)->where('lote',$lote)->get();
                $venc = Vencimiento::where('producto_id',$prod)
                    ->where('lote',$lote)
                    ->update([
                        'entradas' => $v[0]->entradas + $can_ant,
                        'saldo' => $v[0]->saldo + $can_ant
                    ]);
            }
            else{
                $v = Vencimiento::where('producto_id',$prod)->where('lote',$lote)->get();
                $venc = Vencimiento::where('producto_id',$prod)
                    ->where('lote',$lote)
                    ->update([
                        'entradas' => $v[0]->entradas - $can_ant,
                        'saldo' => $v[0]->saldo - $can_ant
                    ]);
            }
            
            //Actualiza sumatoria
            $stafecto = Detingreso::where('ingreso_id', $ingreso_id)->where('afecto', 1)->sum('subtotal');
            $stinafecto = Detingreso::where('ingreso_id', $ingreso_id)->where('afecto', 2)->sum('subtotal');
            $ingreso->subtotal = $stafecto + $stinafecto;
            $ingreso->igv = round($stafecto * (session('igv')/100),2);
            $ingreso->total = $ingreso->subtotal + $ingreso->igv;
            $i = $ingreso->save();
            $kardex = new KardexController();
            $b = $kardex->Regenerate(session('pfarmacia'),$prod);
            return back()->with('message', 'Registro eliminado, se recomienda regenerar stock')->with('typealert', 'success');
        endif;
        // $kardex = new KardexController();
        // $b = $kardex->Regenerate('112020','1');
        // return($b);
    }

    public  function getIngresoEdit($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $detingresos = Detingreso::with(['prod'])->where('ingreso_id', $id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $proveedores = Paciente::orderBy('razsoc','asc')->pluck('razsoc','id');
        $data = [
            'ingreso' => $ingreso,
            'detingresos' => $detingresos,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'proveedores' => $proveedores
        ];
        return view('admin.ingresos.edit', $data);
    }

    public function postIngresoEdit(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required',
    		'serie' => 'required',
    		'numero' => 'required',
    		'proveedor_id' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'serie.required' => 'Ingrese serie.',
    		'numero.required' => 'Ingrese número.',
    		'proveedor_id.required' => 'Ingrese proveedor.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $f = Ingreso::findOrFail($id);
            $f->periodo = e($request->input('periodo'));
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            if(empty($f->cancelacion)){
                $f->cancelacion = null;
            }
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->comprobante_id = e($request->input('comprobante_id'));
            $f->serie = e($request->input('serie'));
            $f->numero = e($request->input('numero'));
            $f->proveedor_id = e($request->input('proveedor_id'));
            $f->subtotal = 0.00;
            $f->igv = 0.00;
            $f->total = 0.00;

            if($f->save()):
    			return redirect('/admin/ingresos/'.session('pfarmacia'))->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getIngresoDelete($id){
        $det = Detingreso::where('ingreso_id', $id)->count();
        if($det == 0){
            $c = Ingreso::findOrFail($id);
            if($c->delete()){
                return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
            }
        }else{
            return back()->with('message', 'No se puede eliminar el registro, contiene detalles')->with('typealert', 'danger');
        }
    }

    public function getIngresoFindLote(Request $request, $producto, $bus)
    {
        if($request->ajax()){
            $venc = Vencimiento::where('producto_id',$producto)
                ->where('lote','like','%'.$bus.'%')
                ->get();
            //$pro = Producto::findOrFail($bus);
            return response()->json($venc);
        }

    }

    public function getIngresoFindLoteId(Request $request, $id)
    {
        if($request->ajax()){
            $venc = Vencimiento::where('id',$id)->get();
            //$pro = Producto::findOrFail($bus);
            return response()->json($venc);
        }

    }
}

