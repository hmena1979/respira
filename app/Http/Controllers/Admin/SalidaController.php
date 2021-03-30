<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Auth;

use App\Http\Models\Salida;
use App\Http\Models\Detsalida;
use App\Http\Models\Producto;
use App\Http\Models\Umedida;
use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Comprobante;
use App\Http\Models\Correlativo;
use App\Http\Models\Afectacion;
use App\Http\Models\Vencimiento;
use App\Http\Models\Kardex;
use App\Http\Models\Param;

class SalidaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getSalidaHome($periodo)
    {
        $salidas = Salida::with(['cli','sta'])->where('periodo',$periodo)->get();
        $data = [
            'salidas' => $salidas,
            'periodo' => $periodo
        ];
        return view('admin.salidas.home', $data);
    }

    public function postSalidaCambio(Request $request){
        $periodo = $request->input('mes').$request->input('año');
        $salidas = Salida::with(['cli','sta'])->where('periodo',$periodo)->get();     
        $data = [
            'salidas' => $salidas,
            'periodo' => $periodo
        ];
        return view('admin.salidas.home', $data);
    }

    public function getSalidaNumero(Request $request, $td)
    {
    	if($request->ajax()){
            $sigla = Comprobante::where('codigo',$td)->value('sigla');
            $parametro = Param::findOrFail(1);
            $serie = $sigla.$parametro->sfarmacia;
            $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
            $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            $numdoc = [$serie,$numero];
            //return {$serie,$numero};
            //return response()->json($numdoc);
            return $numdoc;
    	}
    }

    public function getSalidaAdd()
    {
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->where('codigo','<=','03')->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $serie = 'B'.$parametro->sfarmacia;
        $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
        $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
        $data = [
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'afectacion' => $afectacion,
            'serie' => $serie,
            'numero' => $numero
        ];

        return view('admin.salidas.add', $data);
    }

    public function postSalidaAdd(Request $request)
    {
        $rules = [
    		'fecha' => 'required',
    		'ruc' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'ruc.required' => 'Ingrese cliente.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $anio = substr(e($request->input('fecha')),0,4);
            $mes = substr(e($request->input('fecha')),5,2);
            // session('padmision')
            if($mes <> substr(session('pfarmacia'),0,2) || $anio <> substr(session('pfarmacia'),2,4)){
                return back()->with('message', 'Fecha ingresada no corresponde al periodo')->with('typealert', 'danger')->withinput();
            }
            $numero = strval(Correlativo::where('index',e($request->input('serie')))->value('valor') + 1);
            $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            $f = new Salida;
            $f->periodo = e($request->input('periodo'));
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->hora = e($request->input('hora'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            if(empty($f->cancelacion)){
                $f->cancelacion = null;
            }
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->tipsal = $request->input('tipsal');
            $f->comprobante_id = e($request->input('comprobante_id'));
            $f->serie = e($request->input('serie'));
            $f->numero = $numero;
            $f->fpago_id = e($request->input('fpago_id'));
            $f->noperacion = e($request->input('noperacion'));
            $f->ruc = e($request->input('ruc'));
            $f->direccion = Str::upper(e($request->input('direccion')));
            $f->observaciones = Str::upper(e($request->input('observaciones')));

            if($f->save()):
                $hi = Correlativo::where('index',e($request->input('serie')))
                ->update([
                    'valor' => intval($numero)
                    ]);
    			return redirect('/admin/salida/'.$f->id.'/deta')->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getSalidaDetAdd($id)
    {
        $salida = Salida::findOrFail($id);
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $productos = Producto::orderBy('nombre','asc')->pluck('nombre','id');
        $umedida = Umedida::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $data = [
            'salida' => $salida,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'productos' => $productos,
            'umedida' => $umedida,
            'afectacion' => $afectacion
        ];
        return view('admin.salidas.deta', $data);
    }

    public function postSalidaDetAdd(Request $request, $id)
    {
        $parametro = Param::findOrFail(1);
        $salida = Salida::findOrFail($id);
        $cliente = Paciente::where('numdoc',$salida->ruc)->get();
        $m = '';
        $rules = [
    		'producto_id' => 'required',
    		'cantidad' => 'required',
    		'lote' => 'required'
    	];
    	$messages = [
    		'producto_id.required' => 'Ingrese producto.',
    		'cantidad.required' => 'Ingrese cantidad.',
    		'lote.required' => 'Ingrese lote.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $ds = new Detsalida;
            $ds->salida_id = $id;
            $ds->producto_id = e($request->input('producto_id'));
            $ds->cantidad = e($request->input('cantidad'));
            $ds->preprom = e($request->input('preprom'));
            $ds->precio = e($request->input('precio'));
            $ds->lote = e($request->input('lote'));
            $ds->vence = e($request->input('vence'));
            $ds->subtotal = e($request->input('subtotal'));
            $ds->afectacion_id = e($request->input('afectacion_id'));
            if($ds->save()):
                $afecto = Detsalida::where('salida_id',$id)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('subtotal');
                $inafecto = Detsalida::where('salida_id',$id)
                    ->whereBetween('afectacion_id',['30','39'])
                    ->sum('subtotal');
                $exonerado = Detsalida::where('salida_id',$id)
                    ->whereBetween('afectacion_id',['20','29'])
                    ->sum('subtotal');
                $subtotal = ($afecto / (1+($parametro->por_igv/100)));
                $igv = $afecto - $subtotal;
                $total = Detsalida::where('salida_id',$id)->sum('subtotal');
                $a = Salida::where('id',$id)->update([
                    'tot_gravadas' => $subtotal,
                    'tot_inafectas' => $inafecto,
                    'tot_exoneradas' => $exonerado,
                    'tot_igv' => $igv,
                    'total' => $total
                ]);
                // Actualiza producto
                $p = Producto::findOrFail($ds->producto_id);
            	$p->stock = $p->stock - $ds->cantidad;
            	if($p->save()):
            		$m = $m.'Stock de producto actualizado con exito. ';
                endif;
                // Actualiza Kardex
                $k = new Kardex;
            	$k->periodo = session('pfarmacia');
            	$k->tipo = 2; ////(1)Ingreso (2)Salidas/Consumo
            	$k->operacion_id = $ds->id;
            	$k->producto_id = $ds->producto_id;
            	$k->cliente_id = $cliente[0]->id;
            	$k->documento = numDoc($salida->serie,$salida->numero);
            	$k->proveedor = $cliente[0]->razsoc;
            	$k->fecha = $salida->fecha;
            	$k->cant_sal = $ds->cantidad;
            	$k->cant_sald = $p->stock;
            	$k->pre_prom = $p->precompra;
            	$k->descrip = '';
            	if($k->save()):
            		$m = $m.'Kardex actualizado con exito. ';
                endif;
                // Actualiza Vencimientos
                $v = Vencimiento::where('producto_id',$ds->producto_id)->where('lote',$ds->lote)->get();
                $venc = Vencimiento::where('producto_id',$ds->producto_id)
                    ->where('lote',$ds->lote)
                    ->update([
                        'salidas' => $v[0]->salidas + $ds->cantidad,
                        'saldo' => $v[0]->saldo - $ds->cantidad
                    ]);
                $m = $m.'Lote actualizado con exito. ';
    			return redirect('/admin/salida/'.$id.'/edit')->with('message', 'Registro guardado '.$m)->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getSalidaDetDelete($id)
    {
        $parametro = Param::findOrFail(1);
        $ds = Detsalida::findOrFail($id);
        $salida_id = $ds->salida_id;
        $salida = Salida::findOrFail($salida_id);
        $prod = $ds->producto_id;
        $lote = $ds->lote;
        $cantidad = $ds->cantidad;
        $p = Producto::findOrFail($prod);

        $rstock = $p->stock + $cantidad;
        
        if($ds->delete()):
            $k = Kardex::where('operacion_id',$id)->where('tipo', 2)->delete();
            $p->stock = $rstock;
            $p1 = $p->save();
            //Vencimiento
            $v = Vencimiento::where('producto_id',$prod)->where('lote',$lote)->get();
            $venc = Vencimiento::where('producto_id',$prod)
                ->where('lote',$lote)
                ->update([
                    'salidas' => $v[0]->salidas - $cantidad,
                    'saldo' => $v[0]->saldo + $cantidad
                ]);
            //Actualiza sumatoria
            $afecto = Detsalida::where('salida_id',$id)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('subtotal');
            $inafecto = Detsalida::where('salida_id',$id)
                ->whereBetween('afectacion_id',['30','39'])
                ->sum('subtotal');
            $exonerado = Detsalida::where('salida_id',$id)
                ->whereBetween('afectacion_id',['20','29'])
                ->sum('subtotal');
            $subtotal = ($afecto / (1+($parametro->por_igv/100)));
            $igv = $afecto - $subtotal;
            $total = Detsalida::where('salida_id',$id)->sum('subtotal');
            $a = Salida::where('id',$id)->update([
                'tot_gravadas' => $subtotal,
                'tot_inafectas' => $inafecto,
                'tot_exoneradas' => $exonerado,
                'tot_igv' => $igv,
                'total' => $total
            ]);
            return back()->with('message', 'Registro eliminado, se recomienda regenerar stock')->with('typealert', 'success');
        endif;
        // $kardex = new KardexController();
        // $b = $kardex->Regenerate('112020','1');
        // return($b);
    }

    public function getSalidaEdit($id)
    {
        $salida = Salida::findOrFail($id);
        $detsalidas = Detsalida::with(['prod'])->where('salida_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $status = Categoria::where('modulo', 14)->pluck('nombre','codigo');
        $data = [
            'salida' => $salida,
            'detsalidas' => $detsalidas,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'afectacion' => $afectacion,
            'status' => $status
        ];

        return view('admin.salidas.edit', $data);
    }

    public function postSalidaEdit(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required',
    		'ruc' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'ruc.required' => 'Ingrese cliente.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $f = Salida::findOrFail($id);
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->hora = e($request->input('hora'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            if(empty($f->cancelacion)){
                $f->cancelacion = null;
            }
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->fpago_id = e($request->input('fpago_id'));
            $f->noperacion = e($request->input('noperacion'));
            $f->ruc = e($request->input('ruc'));
            $f->direccion = Str::upper(e($request->input('direccion')));
            $f->observaciones = Str::upper(e($request->input('observaciones')));

            if($f->save()):
    			return redirect('/admin/salidas/'.$f->periodo)->with('message', 'Registro actualizado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getSalidaCambiaFPago($id,$fp,$nope)
    {
        $s = Salida::findOrFail($id);
        $s->fpago_id = $fp;

        if($nope == '99999999'){
            $s->noperacion = '';
        }else{
            $s->noperacion = $nope;
        }
        if($s->save()){
            return true;
        }
    }

    public function getSalidaEnd($id)
    {
        $f = Salida::findOrFail($id);
        $f->status = 2;
        if($f->save()){
            return redirect('/admin/salida/'.$f->id.'/edit')->with('message', 'Estado cambio, Ya puede imprimir o enviar el comprobante')->with('typealert', 'success');            
        }

    }
}
