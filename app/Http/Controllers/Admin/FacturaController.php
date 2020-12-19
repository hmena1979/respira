<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XMLWriter;
use Validator, Str;

use App\Http\Models\Factura;
use App\Http\Models\Detfactura;
use App\Http\Models\Paciente;
use App\Http\Models\Doctor;
use App\Http\Models\Categoria;
use App\Http\Models\Comprobante;
use App\Http\Models\Param;
use App\Http\Models\Correlativo;
use App\Http\Models\Afectacion;
use App\Http\Models\Detraccion;


class FacturaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getFacturaHome($periodo)
    {
        $facturas = Factura::with(['cli','sta'])->where('periodo',$periodo)->get();
        
        $data = [
            'facturas' => $facturas,
            'periodo' => $periodo
        ];
    	return view('admin.facturas.home', $data);
    }

    public function postFacturaCambio(Request $request){
        $periodo = $request->input('mes').$request->input('año');
        $facturas = Factura::with(['cli','sta'])->where('periodo',$periodo)->get();        
        $data = [
            'facturas' => $facturas,
            'periodo' => $periodo
        ];
    	return view('admin.facturas.home', $data);
    }

    public function getFacturaAdd()
    {
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->where('codigo','01')->orWhere('codigo','03')->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $serie = 'B'.$parametro->sadmision;
        $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
        $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
        $data = [
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'doctor' => $doctor,
            'afectacion' => $afectacion,
            'serie' => $serie,
            'numero' => $numero
        ];

        return view('admin.facturas.add', $data);
    }

    public function postFacturaAdd(Request $request)
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
            $numero = strval(Correlativo::where('index',e($request->input('serie')))->value('valor') + 1);
            $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            $f = new Factura;
            $f->periodo = e($request->input('periodo'));
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->hora = e($request->input('hora'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->comprobante_id = e($request->input('comprobante_id'));
            $f->serie = e($request->input('serie'));
            $f->numero = $numero;
            $f->fpago_id = e($request->input('fpago_id'));
            $f->noperacion = e($request->input('noperacion'));
            $f->ruc = e($request->input('ruc'));
            $f->direccion = Str::upper(e($request->input('direccion')));
            $f->doctor_id = e($request->input('doctor_id'));
            $f->observaciones = Str::upper(e($request->input('observaciones')));
            $f->total_clinica = 0;
            $f->total = 0;

            if($f->save()):
                $hi = Correlativo::where('index',e($request->input('serie')))
                ->update([
                    'valor' => intval($numero)
                    ]);
    			return redirect('/admin/factura/'.$f->id.'/deta')->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getFacturaEdit($id)
    {
        $factura = Factura::findOrFail($id);
        $detfacturas = Detfactura::where('factura_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $status = Categoria::where('modulo', 14)->pluck('nombre','codigo');
        $data = [
            'factura' => $factura,
            'detfacturas' => $detfacturas,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'doctor' => $doctor,
            'afectacion' => $afectacion,
            'status' => $status
        ];
        return view('admin.facturas.edit', $data);
    }

    public function postFacturaEdit(Request $request, $id)
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
            $f = Factura::findOrFail($id);
            $f->tipo = e($request->input('tipo'));
            $f->dias = e($request->input('dias'));
            $f->fecha = e($request->input('fecha'));
            $f->vencimiento = e($request->input('vencimiento'));
            $f->cancelacion = e($request->input('cancelacion'));
            $f->moneda = e($request->input('moneda'));
            $f->tc = $request->input('tc')==''?null:e($request->input('tc'));
            $f->fpago_id = e($request->input('fpago_id'));
            $f->noperacion = e($request->input('noperacion'));
            $f->ruc = e($request->input('ruc'));
            $f->direccion = Str::upper(e($request->input('direccion')));
            $f->doctor_id = e($request->input('doctor_id'));
            $f->observaciones = Str::upper(e($request->input('observaciones')));

    		if($f->save()):
    			return redirect('/admin/facturas/'.$f->periodo)->with('message', 'Registro guardado, ingrese detalles del comprobante')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getFacturaEnd($id)
    {
        $f = Factura::findOrFail($id);
        $f->status = 2;
        if($f->save()){
            return redirect('/admin/factura/'.$f->id.'/edit')->with('message', 'Estado cambio, Ya puede imprimir o enviar el comprobante')->with('typealert', 'success');            
        }
    }

    public function getFacturaDelete($id)
    {
        $f = Factura::findOrFail($id);
        if($f->status <> 1){
            return back()->with('message', 'Documento impreso no puede ser eliminado')->with('typealert', 'danger');
        }else{
            if($f->delete()):
                $d = Detfactura::where('factura_id',$id)->delete();
                return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
            endif;
        }
    }

    public function getFacturaCambiaDoctor($id,$doctor_id)
    {
        $f = Factura::findOrFail($id);
        $f->doctor_id = $doctor_id;
        if($f->save()){
            return true;
        }
    }

    public function getFacturaDetAdd($id)
    {
        $factura = Factura::findOrFail($id);
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $data = [
            'factura' => $factura,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'doctor' => $doctor,
            'fpago' => $fpago,
            'afectacion' => $afectacion
        ];
        return view('admin.facturas.deta', $data);
    }

    public function postFacturaDetAdd(Request $request, $id)
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
            $df = new Detfactura;
            $df->factura_id = $id;
            $df->servicio = e($request->input('servicio'));
            $df->cantidad = e($request->input('cantidad'));
            $df->precio = e($request->input('precio'));
            $df->subtotal = e($request->input('subtotal'));
            $df->afectacion_id = e($request->input('afectacion_id'));
            $df->precli = e($request->input('precli'));
            $df->stcli = e($request->input('stcli'));
            $df->predr = e($request->input('predr'));
            $df->stdr = e($request->input('stdr'));
            if($df->save()):
                $afecto = Detfactura::where('factura_id',$id)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('stcli');
                $inafecto = Detfactura::where('factura_id',$id)
                    ->whereBetween('afectacion_id',['30','39'])
                    ->sum('stcli');
                $exonerado = Detfactura::where('factura_id',$id)
                    ->whereBetween('afectacion_id',['20','29'])
                    ->sum('stcli');
                $subtotal = ($afecto / (1+($parametro->por_igv/100)));
                $igv = $afecto - $subtotal;
                $totdr = Detfactura::where('factura_id',$id)->sum('stdr');
                $total = Detfactura::where('factura_id',$id)->sum('subtotal');
                $a = Factura::where('id',$id)->update([
                    'tot_gravadas' => $subtotal,
                    'tot_inafectas' => $inafecto,
                    'tot_exoneradas' => $exonerado,
                    'tot_igv' => $igv,
                    'total_clinica' => $afecto+$inafecto+$exonerado,
                    'total_doctor' => $totdr,
                    'total' => $total
                ]);
    			return redirect('/admin/factura/'.$id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getFacturaDetEdit($id)
    {
        $detfactura = Detfactura::findOrFail($id);
        $factura = Factura::findOrFail($detfactura->factura_id);
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $data = [
            'factura' => $factura,
            'detfactura' => $detfactura,
            'moneda' => $moneda,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'doctor' => $doctor,
            'fpago' => $fpago,
            'afectacion' => $afectacion
        ];
        return view('admin.facturas.dete', $data);
    }

    public function getFacturaDetraccion($id)
    {
        $factura = Factura::findOrFail($id);
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        // $detraccion = Detraccion::pluck('nombre','codigo');
        $detraccion = Detraccion::selectRaw("CONCAT (codigo,' - ',nombre) as columns, codigo")->pluck('columns', 'codigo');
        $parametro = Param::findOrFail(1);
        $data = [
            'factura' => $factura,
            'comprobante' => $comprobante,
            'parametro' => $parametro,
            'clientes' => $clientes,
            'doctor' => $doctor,
            'detraccion' => $detraccion
        ];
        return view('admin.facturas.detraccion', $data);
    }

    public function postFacturaDetraccion(Request $request, $id)
    {
        $rules = [
    		'detraccion_id' => 'required',
    		'detraccion_por' => 'required',
    		'detraccion_monto' => 'required'
    	];
    	$messages = [
    		'detraccion_id.required' => 'Seleccione bien o servicio.',
    		'detraccion_por.required' => 'Ingrese porcentaje.',
    		'detraccion_monto.required' => 'Ingrese monto.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $df = Factura::findOrFail($id);
            $df->detraccion = e($request->input('detraccion'));
            $df->detraccion_id = e($request->input('detraccion_id'));
            $df->detraccion_por = e($request->input('detraccion_por'));
            $df->detraccion_monto = e($request->input('detraccion_monto'));
            if($df->save()):
    			return redirect('/admin/factura/'.$id.'/edit')->with('message', 'Registro actualizado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getFacturaBuscaDetraccion(Request $request, $id)
    {
        if($request->ajax()){
            $detr = Detraccion::where('codigo',$id)->get();
            return response()->json($detr);
        }
    }

    public function getFacturaDetDelete($id)
    {
        $detfactura = Detfactura::findOrFail($id);
        $idf = $detfactura->factura_id;
        $parametro = Param::findOrFail(1);
        if($detfactura->delete()):
            $afecto = Detfactura::where('factura_id',$idf)
                ->whereBetween('afectacion_id',['10','19'])
                ->sum('stcli');
            $exonerado = Detfactura::where('factura_id',$idf)
                ->whereBetween('afectacion_id',['20','29'])
                ->sum('stcli');
            $inafecto = Detfactura::where('factura_id',$idf)
                ->whereBetween('afectacion_id',['30','39'])
                ->sum('stcli');
            $subtotal = ($afecto / (1+($parametro->por_igv/100)));
            $igv = $afecto - $subtotal;
            $totdr = Detfactura::where('factura_id',$idf)->sum('stdr');
            $total = Detfactura::where('factura_id',$idf)->sum('subtotal');
            $a = Factura::where('id',$idf)->update([
                'tot_gravadas' => $subtotal,
                'tot_inafectas' => $inafecto,
                'tot_exoneradas' => $exonerado,
                'tot_igv' => $igv,
                'total_clinica' => $afecto+$inafecto+$exonerado,
                'total_doctor' => $totdr,
                'total' => $total
            ]);

            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function postFacturaDetEdit(Request $request, $id)
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
            $df = Detfactura::findOrFail($id);
            $df->servicio = e($request->input('servicio'));
            $df->cantidad = e($request->input('cantidad'));
            $df->precio = e($request->input('precio'));
            $df->subtotal = e($request->input('subtotal'));
            $df->afectacion_id = e($request->input('afectacion_id'));
            $df->precli = e($request->input('precli'));
            $df->stcli = e($request->input('stcli'));
            $df->predr = e($request->input('predr'));
            $df->stdr = e($request->input('stdr'));
            if($df->save()):
                $idf = $df->factura_id;
                $afecto = Detfactura::where('factura_id',$idf)
                    ->whereBetween('afectacion_id',['10','19'])
                    ->sum('stcli');
                $exonerado = Detfactura::where('factura_id',$idf)
                    ->whereBetween('afectacion_id',['20','29'])
                    ->sum('stcli');
                $inafecto = Detfactura::where('factura_id',$idf)
                    ->whereBetween('afectacion_id',['30','39'])
                    ->sum('stcli');
                $subtotal = ($afecto / (1+($parametro->por_igv/100)));
                $igv = $afecto - $subtotal;
                $totdr = Detfactura::where('factura_id',$idf)->sum('stdr');
                $total = Detfactura::where('factura_id',$idf)->sum('subtotal');
                $a = Factura::where('id',$idf)->update([
                    'tot_gravadas' => $subtotal,
                    'tot_inafectas' => $inafecto,
                    'tot_exoneradas' => $exonerado,
                    'tot_igv' => $igv,
                    'total_clinica' => $afecto+$inafecto+$exonerado,
                    'total_doctor' => $totdr,
                    'total' => $total
                ]);
    			return redirect('/admin/factura/'.$df->factura_id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getFacturaNumero(Request $request, $td)
    {
    	if($request->ajax()){
            $sigla = Comprobante::where('codigo',$td)->value('sigla');
            $parametro = Param::findOrFail(1);
            $serie = $sigla.$parametro->sadmision;
            $numero = strval(Correlativo::where('index',$serie)->value('valor') + 1);
            $numero = str_pad($numero, 8, '0', STR_PAD_LEFT);
            $numdoc = [$serie,$numero];
            //return {$serie,$numero};
            //return response()->json($numdoc);
            return $numdoc;
    	}
    }

    
}
