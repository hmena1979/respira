<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Generator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

use App\Http\Models\Historia;
use App\Http\Models\Paciente;
use App\Http\Models\Receta;
use App\Http\Models\Doctor;
use App\Http\Models\Param;

class RecetaController extends Controller
{
    public function getRecetas()
    {
        return view('recetas');
    }

    public function postRecetas(Request $request)
    {
        $rules = [
    		'codigo' => 'required|numeric'
    	];
    	$messages = [
    		'codigo.required' => 'Ingrese código.',
    		'codigo.numeric' => 'Solo se aceptan números.',
    		'codigo.min' => 'Código contiene 5 dígitos.'
    	];
        $codigo = e($request->input('codigo'));
        if(strlen($codigo)<>8){
            return view('noregistrado');
        }
        $his = substr($codigo,0,5);
        $item = substr($codigo,5,3);
        $pacid = Paciente::where('historia',$his)->value('id');
        $id = Historia::where('paciente_id',$pacid)->where('item',$item)->value('id');
        if(empty($id)){
            return view('noregistrado');
        }
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

        return view('receta');
    }

    // public function __construct(){
	// 	$this->middleware('guest')->except(['getLogout']);
	// }

    public function getReceta($codigo)
    {
        if(strlen($codigo)<>8){
            return view('noregistrado');
        }
        $his = substr($codigo,0,5);
        $item = substr($codigo,5,3);
        $pacid = Paciente::where('historia',$his)->value('id');
        $id = Historia::where('paciente_id',$pacid)->where('item',$item)->value('id');
        if(empty($id)){
            return view('noregistrado');
        }
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

        return view('receta');
    }
}
