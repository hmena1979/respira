<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XMLWriter;
use Validator, Str;

use App\Http\Models\NotaAdm as Nota;
use App\Http\Models\DetNotaAdm as Detnota;
use App\Http\Models\Factura;
use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Comprobante;
use App\Http\Models\Param;
use App\Http\Models\Correlativo;
use App\Http\Models\Afectacion;
use App\Http\Models\Tiponota;

class NotAdmController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getNotAdmHome($periodo)
    {
        $notas = Nota::with(['cli','sta'])->where('periodo',$periodo)->get();
        
        $data = [
            'notas' => $notas,
            'periodo' => $periodo
        ];
    	return view('admin.notadms.home', $data);
    }

    public function postNotAdmCambio(Request $request){
        $periodo = $request->input('mes').$request->input('año');
        $notas = Nota::with(['cli','sta'])->where('periodo',$periodo)->get();        
        $data = [
            'notas' => $notas,
            'periodo' => $periodo
        ];
    	return view('admin.notadms.home', $data);
    }

    public function getNotAdmAdd()
    {
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->where('codigo','07')->orWhere('codigo','08')->pluck('nombre','codigo');
        $dmcomprobante = Comprobante::where('activo',1)->where('codigo','01')->orWhere('codigo','03')->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $tiponota = Tiponota::where('comprobante_id','07')->pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $serie = 'FC01';
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

        return view('admin.notadms.add', $data);
    }

    public function postNotAdmAdd(Request $request)
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
    			return redirect('/admin/notadm/'.$n->id.'/deta')->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getNotAdmEdit($id)
    {
        $nota = Nota::findOrFail($id);
        $detnotas = Detnota::where('notaadm_id',$id)->get();
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
        return view('admin.notadms.edit', $data);
    }

    public function postNotAdmEdit(Request $request, $id)
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
    			return redirect('/admin/notadms/'.$n->periodo)->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getNotAdmDetAdd($id)
    {
        $nota = Nota::findOrFail($id);
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $data = [
            'nota' => $nota,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'afectacion' => $afectacion
        ];
        return view('admin.notadms.deta', $data);
    }

    public function postNotAdmDetAdd(Request $request, $id)
    {
        $parametro = Param::findOrFail(1);
        $rules = [
    		'servicio' => 'required',
    		'cantidad' => 'required',
    		'precio' => 'required'
    	];
    	$messages = [
    		'servicio.required' => 'Ingrese servicio.',
    		'cantidad.required' => 'Ingrese cantidad.',
    		'precio.required' => 'Ingrese precio.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $dn = new Detnota;
            $dn->notaadm_id = $id;
            $dn->servicio = e($request->input('servicio'));
            $dn->cantidad = e($request->input('cantidad'));
            $dn->precio = e($request->input('precio'));
            $dn->subtotal = e($request->input('subtotal'));
            $dn->afectacion_id = e($request->input('afectacion_id'));
            if($dn->save()):
                $afecto = Detnota::where('notaadm_id',$id)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('subtotal');
                $inafecto = Detnota::where('notaadm_id',$id)
                    ->whereBetween('afectacion_id',['30','39'])
                    ->sum('subtotal');
                $exonerado = Detnota::where('notaadm_id',$id)
                    ->whereBetween('afectacion_id',['20','29'])
                    ->sum('subtotal');
                $subtotal = ($afecto / (1+($parametro->por_igv/100)));
                $igv = $afecto - $subtotal;
                $total = Detnota::where('notaadm_id',$id)->sum('subtotal');
                $a = Nota::where('id',$id)->update([
                    'tot_gravadas' => $subtotal,
                    'tot_inafectas' => $inafecto,
                    'tot_exoneradas' => $exonerado,
                    'tot_igv' => $igv,
                    'total' => $total
                ]);
    			return redirect('/admin/notadm/'.$id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getNotAdmDetDelete($id)
    {
        $detnota = Detnota::findOrFail($id);
        $idn = $detnota->notaadm_id;
        $parametro = Param::findOrFail(1);
        if($detnota->delete()):
            $afecto = Detnota::where('notaadm_id',$idn)
                ->whereBetween('afectacion_id',['10','19'])
                ->sum('subtotal');
            $exonerado = Detnota::where('notaadm_id',$idn)
                ->whereBetween('afectacion_id',['20','29'])
                ->sum('subtotal');
            $inafecto = Detnota::where('notaadm_id',$idn)
                ->whereBetween('afectacion_id',['30','39'])
                ->sum('subtotal');
            $subtotal = ($afecto / (1+($parametro->por_igv/100)));
            $igv = $afecto - $subtotal;
            $total = Detnota::where('notaadm_id',$idn)->sum('subtotal');
            $a = Nota::where('id',$idn)->update([
                'tot_gravadas' => $subtotal,
                'tot_inafectas' => $inafecto,
                'tot_exoneradas' => $exonerado,
                'tot_igv' => $igv,
                'total' => $total
            ]);

            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function getNotAdmEnd($id)
    {
        $n = Nota::findOrFail($id);
        $n->status = 2;
        if($n->save()){
            return redirect('/admin/notadm/'.$n->id.'/edit')->with('message', 'Estado cambio, Ya puede imprimir o enviar el comprobante')->with('typealert', 'success');            
        }
    }

    public function getNotAdmNumero(Request $request, $td, $dmtd)
    {
    	if($request->ajax()){
            if($td == '07' && $dmtd == '01'){
                $serie = 'FC01';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '07' && $dmtd == '03'){
                $serie = 'BC01';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '08' && $dmtd == '01'){
                $serie = 'FD01';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }
            if($td == '08' && $dmtd == '03'){
                $serie = 'BD01';
                $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
                $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            }

            $numdoc = [$serie,$numero];
            //return {$serie,$numero};
            //return response()->json($numdoc);
            return $numdoc;
    	}
    }

    public function getNotAdmSelectTipo(Request $request, $id)
    {
        if($request->ajax()){
    		$ddes = Tiponota::where('comprobante_id',$id)->orderBy('nombre','Asc')->get();
    		return response()->json($ddes);
    	}
    }

    
}
