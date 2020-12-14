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

    // Request $request
}
