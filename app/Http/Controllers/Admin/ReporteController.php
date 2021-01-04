<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Doctor;
use App\Http\Models\Servicio;
use App\Http\Models\Correlativo;
use App\Http\Models\Historia;
use App\Http\Models\Param;
use App\Http\Models\Factura;
use App\Http\Models\Detfactura;
use App\Http\Models\Salida;
use App\Http\Models\Detsalida;
use App\Http\Models\Producto;


class ReporteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getReporteAdmision()
    {
        $doctor = Doctor::where('activo',1)->orderBy('nombre')->pluck('nombre','id');
        $servicios = Servicio::orderBy('nombre')->pluck('nombre','id');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $data = [
            'doctor' => $doctor,
            'servicios' => $servicios,
            'fpago' => $fpago
        ];

        return view('admin.report.admision',$data);
    }

    public function getReporteFarmacia()
    {
        $productos = Producto::orderBy('nombre')->pluck('nombre','id');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $data = [
            'productos' => $productos,
            'fpago' => $fpago
        ];

        return view('admin.report.farmacia',$data);
    }

    public function postReportePaciente(Request $request)
    {
        $parametro = Param::findOrFail(1);
        $tp = e($request->input('rpopt'));
        $dr = e($request->input('rpdoctor_id'));
        if($tp == 1){
            $doctores = Doctor::with(['pac'])->get();
        }else{
            $doctores = Doctor::with(['pac'])->where('id',$dr)->get();
        }        

        $data = [
            'parametro' => $parametro,
            'doctores' => $doctores
        ];

        
        if($doctores->count()<300){
            $pdf = PDF::loadView('pdf.rpacientes', $data)->setPaper('A4', 'portrait');
            return $pdf->stream('Pacientes.pdf', array('Attachment'=>false));
        }else{
            $pdf = PDF::loadView('pdf.rpacientes', $data);
            return $pdf->download('Pacientes.pdf');
        }
        
    }

    public function postReporteServicio(Request $request)
    {
        $parametro = Param::findOrFail(1);
        $doctores = Doctor::with(['pac'])->get();
        $opser = e($request->input('rs_opts'));
        $opdr = e($request->input('rs_optd'));
        $opfp = e($request->input('rs_optfp'));
        $grupo = e($request->input('rs_group'));
        $fini = e($request->input('rs_fini'));
        $ffin = e($request->input('rs_ffin'));

        if($opdr == 1){
            $doctor = Factura::with(['dr'])->select('doctor_id')->whereBetween('fecha',[$fini,$ffin])->groupBy('doctor_id')->get();
            $array_dr = Factura::with(['dr'])->whereBetween('fecha',[$fini,$ffin])->groupBy('doctor_id')->pluck('doctor_id');
        }else{
            $doctor = Factura::with(['dr'])->select('doctor_id')
                ->where('doctor_id',$request->input('rs_doctor'))
                ->whereBetween('fecha',[$fini,$ffin])->groupBy('doctor_id')->get();
            $array_dr = Factura::with(['dr'])
                ->where('doctor_id',$request->input('rs_doctor'))
                ->whereBetween('fecha',[$fini,$ffin])->groupBy('doctor_id')->pluck('doctor_id');
        }

        // $array_dr = [];
        // foreach()

        if($opfp == 1){
            $fpago = Factura::with(['fp'])->select('fpago_id')->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }else{
            $fpago = Factura::with(['fp'])->select('fpago_id')
                ->where('fpago_id',$request->input('rs_fpago'))
                ->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }

        if($opser == 1){
            $servicio = Factura::join('detfacturas','facturas.id','detfacturas.factura_id')
                ->whereBetween('fecha',[$fini,$ffin])
                ->where('facturas.anulado',2)
                ->select('detfacturas.servicio')
                ->groupby('detfacturas.servicio')
                ->get();
            $array_serv = Factura::join('detfacturas','facturas.id','detfacturas.factura_id')
                ->whereBetween('fecha',[$fini,$ffin])
                ->where('facturas.anulado',2)
                ->groupby('detfacturas.servicio')
                ->pluck('detfacturas.servicio');
        }else{
            $serobj = Servicio::findOrFail($request->input('rs_servicio'));
            $servicio = Factura::join('detfacturas','facturas.id','detfacturas.factura_id')
                ->whereBetween('fecha',[$fini,$ffin])
                ->where('facturas.anulado',2)
                ->where('detfacturas.servicio',$serobj->nombre)
                ->select('detfacturas.servicio')
                ->groupby('detfacturas.servicio')
                ->get();
            $array_serv = Factura::join('detfacturas','facturas.id','detfacturas.factura_id')
                ->whereBetween('fecha',[$fini,$ffin])
                ->where('facturas.anulado',2)
                ->where('detfacturas.servicio',$serobj->nombre)
                ->groupby('detfacturas.servicio')
                ->pluck('detfacturas.servicio');
        }

        switch($grupo){
            case 1:
                $mov = array();
                foreach($fpago as $fpg){
                    $dt = Factura::with(['cli'])
                    ->join('detfacturas','facturas.id','detfacturas.factura_id')
                    ->whereBetween('fecha',[$fini,$ffin])
                    ->where('facturas.fpago_id',$fpg->fpago_id)
                    ->where('facturas.anulado',2)
                    ->whereNull('detfacturas.deleted_at')
                    ->whereNull('facturas.deleted_at')
                    ->wherein('facturas.doctor_id',$array_dr)
                    ->select('facturas.fecha', 'facturas.ruc','facturas.serie', 'facturas.numero','detfacturas.servicio','detfacturas.stcli','detfacturas.stdr','detfacturas.subtotal')
                    ->get();
                    if($dt->count()>0){
                        $mov[$fpg->fp->nombre] = $dt;
                    }
                    
                }
                // $mov = Factura::with(['cli','det'])
                //     ->join('detfacturas','facturas.id','detfacturas.factura_id')
                //     ->whereBetween('fecha',[$fini,$ffin])
                //     ->select('facturas.*','detfacturas.*')
                //     ->get();
        
                $data = [
                    'fini' => $fini,
                    'ffin' => $ffin,
                    'mov' => $mov,
                    'parametro' => $parametro
                    // 'fpago' => $fpago,
                    // 'doctores' => $doctores
                ];
                $pdf = PDF::loadView('pdf.rmovadm', $data)->setPaper('A4', 'portrait');
                
                break;
            case 2:
                
                $doc = array();
                foreach($servicio as $d){
                    //$mov = array();
                    foreach($fpago as $fpg){
                        $dt = Factura::with(['cli','dr'])
                        ->join('detfacturas','facturas.id','detfacturas.factura_id')
                        ->whereBetween('fecha',[$fini,$ffin])
                        ->where('facturas.fpago_id',$fpg->fpago_id)
                        ->where('facturas.anulado',2)
                        ->where('detfacturas.servicio',$d->servicio)
                        ->whereNull('detfacturas.deleted_at')
                        ->whereNull('facturas.deleted_at')
                        ->wherein('facturas.doctor_id',$array_dr)
                        ->select('facturas.fecha', 'facturas.ruc','facturas.serie', 'facturas.numero','facturas.doctor_id','detfacturas.stcli','detfacturas.stdr','detfacturas.subtotal')
                        ->get();
                        if($dt->count()>0){
                            $doc[$d->servicio][$fpg->fp->nombre] = $dt;
                        }
                        
                    }
                    
                }
                $data = [
                    'fini' => $fini,
                    'ffin' => $ffin,
                    'array_dr' => $array_dr,
                    'doc' => $doc,
                    'servicio' => $servicio,
                    'parametro' => $parametro
                    // 'fpago' => $fpago,
                    // 'doctores' => $doctores
                ];
                $pdf = PDF::loadView('pdf.rmovadm_ser', $data)->setPaper('A4', 'portrait');
                break;

                break;
            case 3:
                $doc = array();
                foreach($doctor as $d){
                    //$mov = array();
                    foreach($fpago as $fpg){
                        $dt = Factura::with(['cli'])
                            ->join('detfacturas','facturas.id','detfacturas.factura_id')
                            ->whereBetween('fecha',[$fini,$ffin])
                            ->where('facturas.fpago_id',$fpg->fpago_id)
                            ->where('facturas.anulado',2)
                            ->where('facturas.doctor_id',$d->doctor_id)
                            ->whereNull('detfacturas.deleted_at')
                            ->whereNull('facturas.deleted_at')
                            ->wherein('detfacturas.servicio',$array_serv)
                            ->select('facturas.fecha', 'facturas.ruc','facturas.serie', 'facturas.numero','detfacturas.servicio','detfacturas.stcli','detfacturas.stdr','detfacturas.subtotal')
                            ->get();
                        if($dt->count()>0){
                            $doc[$d->dr->nombre][$fpg->fp->nombre] = $dt;
                        }
                        
                    }
                    
                }
                
                $data = [
                    'fini' => $fini,
                    'ffin' => $ffin,
                    // 'mov' => $mov,
                    'doc' => $doc,
                    'parametro' => $parametro
                    // 'fpago' => $fpago,
                    // 'doctores' => $doctores
                ];
                $pdf = PDF::loadView('pdf.rmovadm_doc', $data)->setPaper('A4', 'portrait');
                break;
        }
        
        return $pdf->stream('rep.pdf', array('Attachment'=>false));
        //return view('pdf.rmovadm',$data);

        // $pro = Producto::with(['composicion','umedida'])
        //         ->join('composicions','productos.composicion_id','composicions.id')
        //         ->where('productos.nombre','like','%'.$bus.'%')
        //         ->orWhere('composicions.nombre','like','%'.$bus.'%')
        //         ->select('productos.*')
        //         ->take(10)
        //         ->get();

        //return '......';

    }

    public function postReporteProducto()
    {
        $parametro = Param::findOrFail(1);
        $productos = Producto::with(['umedida'])->orderBy('nombre')->get();

        $data = [
            'parametro' => $parametro,
            'productos' => $productos
        ];
        $pdf = PDF::loadView('pdf.rproductos', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('Pacientes.pdf', array('Attachment'=>false));
    }

    public function postReporteMovProducto(Request $request)
    {
        $parametro = Param::findOrFail(1);
        $opprod = e($request->input('rp_optp'));
        $optipo = e($request->input('rp_optt'));
        $opfp = e($request->input('rp_optfp'));
        $grupo = e($request->input('rs_group'));
        $fini = e($request->input('rs_fini'));
        $ffin = e($request->input('rs_ffin'));

        if($optipo == 1){
            $tipo = [1=>'VENTA', 2=>'CONSUMO'];
            $array_tipo = [1,2];
        }else{
            if($request->input('rp_tipo') == 1){
                $tipo = [1=>'VENTA'];
                $array_tipo = [1];
            }else{
                $tipo = [2=>'CONSUMO'];
                $array_tipo = [2];
            }
        }

        if($opfp == 1){
            $fpago = Salida::with(['fp'])->select('fpago_id')->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }else{
            $fpago = Salida::with(['fp'])->select('fpago_id')
                ->where('fpago_id',$request->input('rp_fpago'))
                ->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }

        if($opprod == 1){
            // $producto = Producto::select('productos.id','productos.nombre')
            //     ->join('detsalidas','productos.id','detsalidas.producto_id')
            //     ->join('salidas','detsalidas.salida_id','salidas.id')
            //     ->whereBetween('salidas.fecha',[$fini,$ffin])
            //     ->orderBy('productos.nombre')
            //     ->groupby('productos.id','productos.nombre')
            //     ->get();
            $producto = Detsalida::with('prod')
            ->join('salidas','detsalidas.salida_id','salidas.id')
            ->join('productos','detsalidas.producto_id','productos.id')
            ->whereBetween('salidas.fecha',[$fini,$ffin])
            ->where('salidas.anulado',2)
            ->select('productos.id','productos.nombre')
            ->orderBy('productos.nombre')
            ->groupby('productos.id','productos.nombre')
            ->get();
            $array_prod = Salida::join('detsalidas','salidas.id','detsalidas.salida_id')
                ->whereBetween('fecha',[$fini,$ffin])
                ->where('salidas.anulado',2)
                ->groupby('detsalidas.producto_id')
                ->pluck('detsalidas.producto_id');
        }else{
            $producto = Producto::select('id','nombre')->where('id',$request->input('rp_producto'))->get();
            $array_prod = Producto::where('id',$request->input('rp_producto'))->pluck('id');
        }

        switch($grupo){
            case 1:
                $mov = array();
                foreach($fpago as $fpg){
                    $dt = Salida::with(['cli'])
                    ->join('detsalidas','salidas.id','detsalidas.salida_id')
                    ->join('productos','detsalidas.producto_id','productos.id')
                    ->whereBetween('fecha',[$fini,$ffin])
                    ->where('salidas.fpago_id',$fpg->fpago_id)
                    ->where('salidas.anulado',2)
                    ->whereNull('detsalidas.deleted_at')
                    ->whereNull('salidas.deleted_at')
                    ->wherein('salidas.tipsal',$array_tipo)
                    ->wherein('detsalidas.producto_id',$array_prod)
                    ->select('salidas.fecha', 'salidas.ruc','salidas.serie', 'salidas.numero','productos.nombre as producto','detsalidas.cantidad','detsalidas.precio','detsalidas.subtotal')
                    ->get();
                    if($dt->count()>0){
                        $mov[$fpg->fp->nombre] = $dt;
                    }
                }
        
                $data = [
                    'fini' => $fini,
                    'ffin' => $ffin,
                    'mov' => $mov,
                    'fpago' => $fpago,
                    'parametro' => $parametro
                ];
                $pdf = PDF::loadView('pdf.rmovfar', $data)->setPaper('A4', 'portrait');
                // return view('pdf.rmovfar',$data);
                
                break;
            case 2:
                $doc = array();
                foreach($producto as $d){
                    $dt = Salida::with(['cli'])
                    ->join('detsalidas','salidas.id','detsalidas.salida_id')
                    ->whereBetween('fecha',[$fini,$ffin])
                    // ->where('salidas.fpago_id',$fpg->fpago_id)
                    ->where('salidas.anulado',2)
                    ->where('detsalidas.producto_id',$d->id)
                    ->whereNull('detsalidas.deleted_at')
                    ->whereNull('salidas.deleted_at')
                    ->select('salidas.fecha', 'salidas.ruc','salidas.serie', 'salidas.numero','detsalidas.cantidad','detsalidas.precio','detsalidas.subtotal')
                    ->get();
                    if($dt->count()>0){
                        $doc[$d->nombre] = $dt;
                    }
                }
                $data = [
                    'fini' => $fini,
                    'ffin' => $ffin,
                    'doc' => $doc,
                    'producto' => $producto,
                    'parametro' => $parametro
                ];
                $pdf = PDF::loadView('pdf.rmovfarprod', $data)->setPaper('A4', 'portrait');
                break;
        }
        
        return $pdf->stream('rep.pdf', array('Attachment'=>false));
    }

    public function postReporteMovComprobantes(Request $request)
    {
        $parametro = Param::findOrFail(1);
        $optipo = e($request->input('lis_optt'));
        $opfp = e($request->input('lis_optfp'));
        $grupo = e($request->input('rs_group'));
        $fini = e($request->input('lis_fini'));
        $ffin = e($request->input('lis_ffin'));

        if($optipo == 1){
            $tipo = [1=>'VENTA', 2=>'CONSUMO'];
            $array_tipo = [1,2];
        }else{
            if($request->input('lis_tipo') == 1){
                $tipo = [1=>'VENTA'];
                $array_tipo = [1];
            }else{
                $tipo = [2=>'CONSUMO'];
                $array_tipo = [2];
            }
        }

        if($opfp == 1){
            $fpago = Salida::with(['fp'])->select('fpago_id')->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }else{
            $fpago = Salida::with(['fp'])->select('fpago_id')
                ->where('fpago_id',$request->input('lis_fpago'))
                ->whereBetween('fecha',[$fini,$ffin])->groupBy('fpago_id')->get();
        }
        $mov = array();
        foreach($fpago as $fpg){
            $dt = Salida::with(['cli','sta'])
            ->whereBetween('fecha',[$fini,$ffin])
            ->where('fpago_id',$fpg->fpago_id)
            ->where('anulado',2)
            ->wherein('tipsal',$array_tipo)
            ->select('fecha', 'ruc','comprobante_id','serie', 'numero','total','tipsal','status','cdr')
            ->get();
            if($dt->count()>0){
                $mov[$fpg->fp->nombre] = $dt;
            }
        }

        $data = [
            'fini' => $fini,
            'ffin' => $ffin,
            'mov' => $mov,
            'parametro' => $parametro
        ];
        $pdf = PDF::loadView('pdf.rmovfarcomp', $data)->setPaper('A4', 'portrait');
        // return view('pdf.rmovfar',$data);
        return $pdf->stream('rep.pdf', array('Attachment'=>false));
    }

    


}
