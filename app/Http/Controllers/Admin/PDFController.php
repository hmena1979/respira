<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Generator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Luecano\NumeroALetras\NumeroALetras;
// use XMLWriter;
// use Storage;
// use ZipArchive;
// use Greenter\XMLSecLibs\Sunat\SignedXml;
// use Greenter\XMLSecLibs\Certificate\X509Certificate;
// use Greenter\XMLSecLibs\Certificate\X509ContentType;

// use Greenter\Ws\Services\SoapClient;
// use Greenter\Ws\Services\BillSender;

use App\Http\Models\Historia;
use App\Http\Models\Paciente;
use App\Http\Models\Receta;
use App\Http\Models\Doctor;
use App\Http\Models\Categoria;
use App\Http\Models\Umedida;
use App\Http\Models\Factura;
use App\Http\Models\Detfactura;
use App\Http\Models\Salida;
use App\Http\Models\Detsalida;
use App\Http\Models\NotaAdm;
use App\Http\Models\DetNotaAdm;
use App\Http\Models\NotaFar;
use App\Http\Models\DetNotaFar;

use App\Http\Models\Comprobante;
use App\Http\Models\Afectacion;
use App\Http\Models\Param;

class PDFController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getReceta($id)
    {
        $historia = Historia::findOrFail($id);
        $paciente = Paciente::where('id',$historia->paciente_id)->first();
        $doctor = Doctor::where('id',$historia->doctor_id)->first();
        $recetas = Receta::with(['um','pmed','pfre','ptie'])->where('historia_id', $id)->get();
        $qrcode = base64_encode(QrCode::format('svg')
            ->size(100)
            ->errorCorrection('H')
            ->generate('www.cnnrespira.com/'.$paciente->historia.$historia->item.'/receta'));
        $data = [
            'historia' => $historia,
            'paciente' => $paciente,
            'recetas' => $recetas,
            'doctor' => $doctor,
            'qrcode' => $qrcode
        ];

        //$pdf = PDF::loadView('pdf.receta', $data)->setPaper('A4', 'landscape');
        $pdf = PDF::loadView('pdf.receta', $data)
            ->setPaper(array(0,0,595.28,768.19), 'landscape');
        return $pdf->stream($historia->id.$historia->item.'.pdf', array('Attachment'=>false));
        
        //return view('pdf.receta', $data);
    }
    public function getRecetaV($id)
    {
        $historia = Historia::findOrFail($id);
        $paciente = Paciente::findOrFail($historia->paciente_id);
        $doctor = Doctor::findOrFail($historia->doctor_id);
        $parametro = Param::findOrFail(1);
        $recetas = Receta::with(['um','pmed','pfre','ptie'])->where('historia_id', $id)->get();
        $qrcode = base64_encode(QrCode::format('svg')
            ->size(100)
            ->errorCorrection('H')
            ->generate($parametro->dominio.'/receta'.'/'.$paciente->historia.$historia->item));
        //$qrcode->size(500)->generate('Crea un QrCode sin Laravel!');
        $data = [
            'historia' => $historia,
            'paciente' => $paciente,
            'recetas' => $recetas,
            'doctor' => $doctor,
            'parametro' => $parametro,
            'qrcode' => $qrcode
        ];

        $pdf = PDF::loadView('pdf.recetanew', $data)->setPaper('A4', 'portrait');
        return $pdf->stream($historia->id.$historia->item.'.pdf', array('Attachment'=>false));
        
        //return view('pdf.receta', $data);
    }

    public function getRecetaPlan($id)
    {
        $historia = Historia::findOrFail($id);
        $paciente = Paciente::findOrFail($historia->paciente_id);
        $doctor = Doctor::findOrFail($historia->doctor_id);
        $parametro = Param::findOrFail(1);
        $recetas = Receta::with(['um','pmed','pfre','ptie'])->where('historia_id', $id)->get();
        $qrcode = base64_encode(QrCode::format('svg')
            ->size(100)
            ->errorCorrection('H')
            ->generate($parametro->dominio.'/receta'.'/'.$paciente->historia.$historia->item));
        //$qrcode->size(500)->generate('Crea un QrCode sin Laravel!');
        
        //----------------------------------------------------------------------------------------------
        $radio = false;
        if(kvfj($historia->radtorax, 'senpar') || kvfj($historia->radtorax, 'cavum') || kvfj($historia->radtorax, 'torax') || kvfj($historia->radtorax, 'parrcostal')
            || kvfj($historia->radtorax, '1incidencia') || kvfj($historia->radtorax, 'frontal') || kvfj($historia->radtorax, 'lateral')
            || kvfj($historia->radtorax, '2incidencia') || kvfj($historia->radtorax, 'otpradio')){
            $radio = true;
        }
        $ecograf = false;
        if(kvfj($historia->radtorax, 'ecografia') || kvfj($historia->radtorax, 'ecotex') || kvfj($historia->radtorax, 'dpresuntivo')
            || kvfj($historia->radtorax, 'dclinico')){
            $ecograf = true;
        }
        $tomogra = false;
        if(kvfj($historia->tomografia, 'ccontraste') || kvfj($historia->tomografia, 'scontraste') || kvfj($historia->tomografia, 'sparanasal')
            || kvfj($historia->tomografia, 'cuello') || kvfj($historia->tomografia, 'ttorax') || kvfj($historia->tomografia, 'tpm') || kvfj($historia->tomografia, 'tar')
            || kvfj($historia->tomografia, 'ptpc') || kvfj($historia->tomografia, 'vas3d') || kvfj($historia->tomografia, 'angiotem') || kvfj($historia->tomografia, 'toraxico')
            || kvfj($historia->tomografia, 'otptomografia')){
            $tomogra = true;
        }
        $espiro = false;
        if(kvfj($historia->espirometria, 'esimple') || kvfj($historia->espirometria, 'emb') || kvfj($historia->espirometria, 'tc')
            || kvfj($historia->espirometria, 'on') || kvfj($historia->espirometria, 'pmd') || kvfj($historia->espirometria, 'flujo')
            || kvfj($historia->espirometria, 'opruebas')){
            $espiro = true;
        }

        $data = [
            'historia' => $historia,
            'paciente' => $paciente,
            'recetas' => $recetas,
            'doctor' => $doctor,
            'parametro' => $parametro,
            'qrcode' => $qrcode,
            'radio' => $radio,
            'ecograf' => $ecograf,
            'tomogra' => $tomogra,
            'espiro' => $espiro
        ];        
        //----------------------------------------------------------------------------------------------

        $pdf = PDF::loadView('pdf.recetanewplan', $data)->setPaper('A4', 'portrait');
        return $pdf->stream($historia->id.$historia->item.'.pdf', array('Attachment'=>false));
        
        //return view('pdf.receta', $data);
    }

    public function getAdmFacturacion($id)
    {
        $factura = Factura::with(['cli','mon'])->findOrFail($id);
        $detfacturas = Detfactura::where('factura_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $qtext = $parametro->ruc.'|'
            .$factura->comprobante_id.'|'
            .$factura->serie.'|'
            .$factura->numero.'|'
            .$factura->tot_igv.'|'
            .$factura->total_clinica.'|'
            .$factura->fecha.'|'
            .$factura->cli->tipdoc_id.'|'
            .$factura->ruc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $formatter = new NumeroALetras();
        if($factura->moneda=='PEN'){
            $letra = $formatter->toInvoice($factura->total_clinica, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($factura->total_clinica, 2, 'dólares americanos');
        }
        if($factura->status==2){
            $factura->status = 3;
            $factura->save();
        }
        $data = [
            'factura' => $factura,
            'detfacturas' => $detfacturas,
            'moneda' => $moneda,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'qrcode' => $qrcode,
            'letra' => $letra
        ];
        if($factura->comprobante_id=='01'){
            $pdf = PDF::loadView('pdf.factura', $data)->setPaper('A4', 'portrait');
        }else{
            $pdf = PDF::loadView('pdf.boleta', $data)->setPaper('A4', 'portrait');
        }
        //header('Content-Type: application/json');
        return $pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        //return view('pdf.factura', $data);
    }

    public function getAdmNotas($id)
    {
        $nota = NotaAdm::with(['cli','dmcomp','mon'])->findOrFail($id);
        $detnotas = DetNotaAdm::where('notaadm_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $qtext = $parametro->ruc.'|'
            .$nota->comprobante_id.'|'
            .$nota->serie.'|'
            .$nota->numero.'|'
            .$nota->tot_igv.'|'
            .$nota->total.'|'
            .$nota->fecha.'|'
            .$nota->cli->tipdoc_id.'|'
            .$nota->ruc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $formatter = new NumeroALetras();
        if($nota->moneda=='PEN'){
            $letra = $formatter->toInvoice($nota->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($nota->total, 2, 'dólares americanos');
        }
        if($nota->status==2){
            $nota->status = 3;
            $nota->save();
        }
        $data = [
            'nota' => $nota,
            'detnotas' => $detnotas,
            'moneda' => $moneda,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'qrcode' => $qrcode,
            'letra' => $letra
        ];
        if($nota->comprobante_id=='07'){
            $pdf = PDF::loadView('pdf.ncadm', $data)->setPaper('A4', 'portrait');
        }else{
            $pdf = PDF::loadView('pdf.ndadm', $data)->setPaper('A4', 'portrait');
        }
        //header('Content-Type: application/json');
        return $pdf->stream($parametro->ruc.'-'.$nota ->comprobante_id.'-'.$nota ->serie.'-'.$nota ->numero.'.pdf', array('Attachment'=>false));
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        //return view('pdf.factura', $data);
    }

    public function getFarmFacturacion($id)
    {
        $salida = Salida::with(['cli','mon'])->findOrFail($id);
        $detsalidas = Detsalida::where('salida_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $qtext = $parametro->ruc.'|'
            .$salida->comprobante_id.'|'
            .$salida->serie.'|'
            .$salida->numero.'|'
            .$salida->tot_igv.'|'
            .$salida->total.'|'
            .$salida->fecha.'|'
            .$salida->cli->tipdoc_id.'|'
            .$salida->ruc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $formatter = new NumeroALetras();
        if($salida->moneda=='PEN'){
            $letra = $formatter->toInvoice($salida->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($salida->total, 2, 'dólares americanos');
        }
        if($salida->status==2){
            $salida->status = 3;
            $salida->save();
        }
        $data = [
            'salida' => $salida,
            'detsalidas' => $detsalidas,
            'moneda' => $moneda,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'qrcode' => $qrcode,
            'letra' => $letra
        ];
        if($salida->comprobante_id=='01'){
            $pdf = PDF::loadView('pdf.factfarm', $data)->setPaper('A4', 'portrait');
        }else{
            $pdf = PDF::loadView('pdf.bolfarm', $data)->setPaper('A4', 'portrait');
        }
        //header('Content-Type: application/json');
        return $pdf->stream($parametro->ruc.'-'.$salida->comprobante_id.'-'.$salida->serie.'-'.$salida->numero.'.pdf', array('Attachment'=>false));
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        //return view('pdf.factura', $data);
    }

    public function getFarmNotas($id)
    {
        $nota = NotaFar::with(['cli','dmcomp','mon'])->findOrFail($id);
        $detnotas = DetNotaFar::where('notafar_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $qtext = $parametro->ruc.'|'
            .$nota->comprobante_id.'|'
            .$nota->serie.'|'
            .$nota->numero.'|'
            .$nota->tot_igv.'|'
            .$nota->total.'|'
            .$nota->fecha.'|'
            .$nota->cli->tipdoc_id.'|'
            .$nota->ruc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $formatter = new NumeroALetras();
        if($nota->moneda=='PEN'){
            $letra = $formatter->toInvoice($nota->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($nota->total, 2, 'dólares americanos');
        }
        if($nota->status==2){
            $nota->status = 3;
            $nota->save();
        }
        $data = [
            'nota' => $nota,
            'detnotas' => $detnotas,
            'moneda' => $moneda,
            'parametro' => $parametro,
            'fpago' => $fpago,
            'clientes' => $clientes,
            'qrcode' => $qrcode,
            'letra' => $letra
        ];
        if($nota->comprobante_id=='07'){
            $pdf = PDF::loadView('pdf.ncfar', $data)->setPaper('A4', 'portrait');
        }else{
            $pdf = PDF::loadView('pdf.ndfar', $data)->setPaper('A4', 'portrait');
        }
        //header('Content-Type: application/json');
        return $pdf->stream($parametro->ruc.'-'.$nota ->comprobante_id.'-'.$nota ->serie.'-'.$nota ->numero.'.pdf', array('Attachment'=>false));
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        //return view('pdf.factura', $data);
    }

    // public function getReportePacientes()
    // {
    //     $paciente = Paciente::orderBy('doctor_id')->orderBy('razsoc')->get();
    //     $doctor = Doctor::where('id',$historia->doctor_id)->first();
    //     $recetas = Receta::with(['um','pmed','pfre','ptie'])->where('historia_id', $id)->get();
    //     $qrcode = base64_encode(QrCode::format('svg')
    //         ->size(100)
    //         ->errorCorrection('H')
    //         ->generate('www.cnnrespira.com/'.$paciente->historia.$historia->item.'/receta'));
    //     $data = [
    //         'historia' => $historia,
    //         'paciente' => $paciente,
    //         'recetas' => $recetas,
    //         'doctor' => $doctor,
    //         'qrcode' => $qrcode
    //     ];

    //     //$pdf = PDF::loadView('pdf.receta', $data)->setPaper('A4', 'landscape');
    //     $pdf = PDF::loadView('pdf.receta', $data)
    //         ->setPaper(array(0,0,595.28,768.19), 'landscape');
    //     return $pdf->stream($historia->id.$historia->item.'.pdf', array('Attachment'=>false));
        
    //     //return view('pdf.receta', $data);
    // }

    
}
