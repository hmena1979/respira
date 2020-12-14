<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XMLWriter;
use Validator, Str;

use App\Http\Models\NotaFar as Nota;
use App\Http\Models\DetNotaFar as Detnota;
use App\Http\Models\Factura;
use App\Http\Models\Producto;
use App\Http\Models\Umedida;
use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Comprobante;
use App\Http\Models\Param;
use App\Http\Models\Correlativo;
use App\Http\Models\Kardex;
use App\Http\Models\Vencimiento;
use App\Http\Models\Afectacion;
use App\Http\Models\Tiponota;

class NotFarController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getNotFarHome($periodo)
    {
        $notas = Nota::with(['cli','sta'])->where('periodo',$periodo)->get();
        
        $data = [
            'notas' => $notas,
            'periodo' => $periodo
        ];
    	return view('admin.notfars.home', $data);
    }

    public function postNotFarCambio(Request $request){
        $periodo = $request->input('mes').$request->input('año');
        $notas = Nota::with(['cli','sta'])->where('periodo',$periodo)->get();        
        $data = [
            'notas' => $notas,
            'periodo' => $periodo
        ];
    	return view('admin.notfars.home', $data);
    }

    public function getNotFarAdd()
    {
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->where('codigo','07')->orWhere('codigo','08')->pluck('nombre','codigo');
        $dmcomprobante = Comprobante::where('activo',1)->where('codigo','01')->orWhere('codigo','03')->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $tiponota = Tiponota::where('comprobante_id','07')->pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $serie = 'FC02';
        $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
        $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
        $data = [
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'dmcomprobante' => $dmcomprobante,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'afectacion' => $afectacion,
            'tiponota' => $tiponota,
            'serie' => $serie,
            'numero' => $numero
        ];

        return view('admin.notfars.add', $data);
    }

    public function postNotFarAdd(Request $request)
    {
        $rules = [
    		'fecha' => 'required',
    		'ruc' => 'required',
    		'dmserie' => 'required',
    		'dmnumero' => 'required',
    		'dmtipo_id' => 'required',
    		'dmdescripcion' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'ruc.required' => 'Ingrese cliente.',
    		'dmserie.required' => 'Ingrese serie del documento a modificar.',
    		'dmnumero.required' => 'Ingrese número del documento a modificar.',
    		'dmtipo_id.required' => 'Ingrese tipo.',
    		'dmdescripcion.required' => 'Ingrese descripción.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $numero = strval(Correlativo::where('index',e($request->input('serie')))->value('valor') + 1);
            $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            $n = new Nota;
            $n->periodo = e($request->input('periodo'));
            $n->fecha = e($request->input('fecha'));
            $n->hora = e($request->input('hora'));
            $n->moneda = e($request->input('moneda'));
            $n->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $n->comprobante_id = e($request->input('comprobante_id'));
            $n->serie = e($request->input('serie'));
            $n->numero = $numero;
            $n->dmcomprobante_id = e($request->input('dmcomprobante_id'));
            $n->dmserie = e($request->input('dmserie'));
            $n->dmnumero = e($request->input('dmnumero'));
            $n->dmtipo_id = e($request->input('dmtipo_id'));
            $n->dmdescripcion = e($request->input('dmdescripcion'));
            $n->ruc = e($request->input('ruc'));
            $n->direccion = Str::upper(e($request->input('direccion')));
            $n->observaciones = Str::upper(e($request->input('observaciones')));
            $n->total = 0;

            if($n->save()):
                $hi = Correlativo::where('index',e($request->input('serie')))
                ->update([
                    'valor' => intval($numero)
                    ]);
                // $f = Factura::where('comprobante_id',$n->dmcomprobante_id)
                //     ->where('serie',$n->dmserie)->where('numero',$n->dmnumero)
                //     ->update(['status'=>'7']);
    			return redirect('/admin/notfar/'.$n->id.'/deta')->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getNotFarEdit($id)
    {
        $nota = Nota::findOrFail($id);
        $detnotas = Detnota::with(['prod'])->where('notafar_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $dmcomprobante = Comprobante::where('activo',1)->where('codigo','01')->orWhere('codigo','03')->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $tiponota = Tiponota::where('comprobante_id','07')->pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $status = Categoria::where('modulo', 14)->pluck('nombre','codigo');
        $data = [
            'nota' => $nota,
            'detnotas' => $detnotas,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'dmcomprobante' => $dmcomprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'afectacion' => $afectacion,
            'tiponota' => $tiponota,
            'status' => $status
        ];
        return view('admin.notfars.edit', $data);
    }

    public function postNotFarEdit(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required',
    		'ruc' => 'required',
    		'dmserie' => 'required',
    		'dmnumero' => 'required',
    		'dmtipo_id' => 'required',
    		'dmdescripcion' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'ruc.required' => 'Ingrese cliente.',
    		'dmserie.required' => 'Ingrese serie del documento a modificar.',
    		'dmnumero.required' => 'Ingrese número del documento a modificar.',
    		'dmtipo_id.required' => 'Ingrese tipo.',
    		'dmdescripcion.required' => 'Ingrese descripción.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $n = Nota::findOrFail($id);
            $n->fecha = e($request->input('fecha'));
            $n->moneda = e($request->input('moneda'));
            $n->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $n->dmserie = e($request->input('dmserie'));
            $n->dmnumero = e($request->input('dmnumero'));
            $n->dmtipo_id = e($request->input('dmtipo_id'));
            $n->dmdescripcion = e($request->input('dmdescripcion'));
            $n->ruc = e($request->input('ruc'));
            $n->direccion = Str::upper(e($request->input('direccion')));
            $n->observaciones = Str::upper(e($request->input('observaciones')));
    		if($n->save()):
    			return redirect('/admin/notfars/'.$n->periodo)->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getNotFarDetAdd($id)
    {
        $nota = Nota::findOrFail($id);
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $productos = Producto::orderBy('nombre','asc')->pluck('nombre','id');
        $umedida = Umedida::orderBy('nombre','asc')->pluck('nombre','id');
        $parametro = Param::findOrFail(1);
        $data = [
            'nota' => $nota,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'productos' => $productos,
            'umedida' => $umedida,
            'afectacion' => $afectacion
        ];
        return view('admin.notfars.deta', $data);
    }

    public function postNotFarDetAdd(Request $request, $id)
    {
        $parametro = Param::findOrFail(1);
        $nota = Nota::findOrFail($id);
        $cliente = Paciente::where('numdoc',$nota->ruc)->get();
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
            $ds = new Detnota;
            $ds->notafar_id = $id;
            $ds->producto_id = e($request->input('producto_id'));
            $ds->cantidad = e($request->input('cantidad'));
            $ds->preprom = e($request->input('preprom'));
            $ds->precio = e($request->input('precio'));
            $ds->lote = e($request->input('lote'));
            $ds->vence = e($request->input('vence'));
            $ds->subtotal = e($request->input('subtotal'));
            $ds->afectacion_id = e($request->input('afectacion_id'));
            if($ds->save()):
                $afecto = Detnota::where('notafar_id',$id)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('subtotal');
                $inafecto = Detnota::where('notafar_id',$id)
                    ->whereBetween('afectacion_id',['30','39'])
                    ->sum('subtotal');
                $exonerado = Detnota::where('notafar_id',$id)
                    ->whereBetween('afectacion_id',['20','29'])
                    ->sum('subtotal');
                $subtotal = ($afecto / (1+($parametro->por_igv/100)));
                $igv = $afecto - $subtotal;
                $total = Detnota::where('notafar_id',$id)->sum('subtotal');
                $a = Nota::where('id',$id)->update([
                    'tot_gravadas' => $subtotal,
                    'tot_inafectas' => $inafecto,
                    'tot_exoneradas' => $exonerado,
                    'tot_igv' => $igv,
                    'total' => $total
                ]);
                if($nota->comprobante_id == '07'){
                    // Actualiza producto
                    $p = Producto::findOrFail($ds->producto_id);
                    $p->stock = $p->stock + $ds->cantidad;
                    if($p->save()):
                        $m = $m.'Stock de producto actualizado con exito. ';
                    endif;
                    
                    // Actualiza Kardex
                    $k = new Kardex;
                    $k->periodo = session('pfarmacia');
                    $k->tipo = 3; ////(1)Ingreso (2)Salidas/Consumo (3)Nota Credito
                    $k->operacion_id = $ds->id;
                    $k->producto_id = $ds->producto_id;
                    $k->cliente_id = $cliente[0]->id;
                    $k->documento = numDoc($nota->serie,$nota->numero);
                    $k->proveedor = $cliente[0]->razsoc;
                    $k->fecha = $nota->fecha;
                    $k->cant_ent = $ds->cantidad;
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
                            'salidas' => $v[0]->salidas - $ds->cantidad,
                            'saldo' => $v[0]->saldo + $ds->cantidad
                        ]);
                    $m = $m.'Lote actualizado con exito. ';
                }
    			return redirect('/admin/notfar/'.$id.'/edit')->with('message', 'Registro guardado '.$m)->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getNotFarDetDelete($id)
    {
        $dn = Detnota::findOrFail($id);
        $idn = $dn->notafar_id;
        $parametro = Param::findOrFail(1);

        $nota = Nota::findOrFail($idn);
        $prod = $dn->producto_id;
        $lote = $dn->lote;
        $cantidad = $dn->cantidad;
        $p = Producto::findOrFail($prod);
        $m = '';

        if($dn->delete()):
            $afecto = Detnota::where('notafar_id',$idn)
                ->whereBetween('afectacion_id',['10','19'])
                ->sum('subtotal');
            $exonerado = Detnota::where('notafar_id',$idn)
                ->whereBetween('afectacion_id',['20','29'])
                ->sum('subtotal');
            $inafecto = Detnota::where('notafar_id',$idn)
                ->whereBetween('afectacion_id',['30','39'])
                ->sum('subtotal');
            $subtotal = ($afecto / (1+($parametro->por_igv/100)));
            $igv = $afecto - $subtotal;
            $total = Detnota::where('notafar_id',$idn)->sum('subtotal');
            $a = Nota::where('id',$idn)->update([
                'tot_gravadas' => $subtotal,
                'tot_inafectas' => $inafecto,
                'tot_exoneradas' => $exonerado,
                'tot_igv' => $igv,
                'total' => $total
            ]);
            if($nota->comprobante_id == '07'){
                // Actualiza producto
                $p->stock = $p->stock - $cantidad;
                $p1 = $p->save();
                $k = Kardex::where('operacion_id',$id)->where('tipo', 3)->delete();
                //Vencimiento
                $v = Vencimiento::where('producto_id',$prod)->where('lote',$lote)->get();
                $venc = Vencimiento::where('producto_id',$prod)
                    ->where('lote',$lote)
                    ->update([
                        'salidas' => $v[0]->salidas + $cantidad,
                        'saldo' => $v[0]->saldo - $cantidad
                    ]);


                $m = $m.'Lote actualizado con exito. ';
            }

            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function getNotFarEnd($id)
    {
        $n = Nota::findOrFail($id);
        $n->status = 2;
        if($n->save()){
            return redirect('/admin/notfar/'.$n->id.'/edit')->with('message', 'Estado cambio, Ya puede imprimir o enviar el comprobante')->with('typealert', 'success');            
        }
    }

    public function getNotFarNumero(Request $request, $td, $dmtd)
    {
    	if($request->ajax()){
            if($td == '07' && $dmtd == '01'){
                $serie = 'FC02';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '07' && $dmtd == '03'){
                $serie = 'BC02';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '08' && $dmtd == '01'){
                $serie = 'FD02';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '08' && $dmtd == '03'){
                $serie = 'BD02';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }

            $numdoc = [$serie,$numero];
            //return {$serie,$numero};
            //return response()->json($numdoc);
            return $numdoc;
    	}
    }

    public function getNotFarSelectTipo(Request $request, $id)
    {
        if($request->ajax()){
    		$ddes = Tiponota::where('comprobante_id',$id)->orderBy('nombre','Asc')->get();
    		return response()->json($ddes);
    	}
    }

}
