<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Terapia;
use App\Http\Models\Detterapiaeval;
use App\Http\Models\Detterapiaeval2;
use App\Http\Models\Paciente;
use App\Http\Models\Doctor;
use App\Http\Models\Categoria;

class TerapiaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getTerapiaHome()
    {
        $terapias = Terapia::with(['pac'])->get();
        $data = [
            'terapias' => $terapias
        ];
        return view('admin.terapias.home', $data);
    }

    public function getTerapiaAdd()
    {
        $pacientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','id');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $data = [
            'pacientes' => $pacientes,
            'doctor' => $doctor,
            'sexo' => $sexo
        ];
        return view('admin.terapias.add', $data);
    }

    public function postTerapiaAdd(Request $request)
    {
    	$rules = [
    		'razsoc' => 'required',
    		'fechaeval' => 'required'
    	];
    	$messages = [
    		'razsoc.required' => 'Ingrese paciente.',
    		'fechaeval.required' => 'Ingrese fecha de evaluación.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$terapia = new Terapia;
            $terapia->paciente_id = $request->input('razsoc');
    		$terapia->diagnostico = Str::upper(e($request->input('diagnostico')));
            $terapia->hospitalizacion = $request->input('hospitalizacion');
            $terapia->hospfech = Str::upper(e($request->input('hospfech')));
            $terapia->hosplugar = Str::upper(e($request->input('hosplugar')));
            $terapia->hospalta = Str::upper(e($request->input('hospalta')));
            $terapia->fechaeval = $request->input('fechaeval');
            $terapia->altura = Str::upper(e($request->input('altura')));
            $terapia->peso = Str::upper(e($request->input('peso')));
            $terapia->pesoglosa = Str::upper(e($request->input('pesoglosa')));
            $terapia->fumador = $request->input('fumador');
            $terapia->fumcese = Str::upper(e($request->input('fumcese')));
            $terapia->spo2 = Str::upper(e($request->input('spo2')));
            $terapia->fc = Str::upper(e($request->input('fc')));
            $terapia->resxmin = Str::upper(e($request->input('resxmin')));
            $terapia->pa = Str::upper(e($request->input('pa')));
            $terapia->ocupacion = Str::upper(e($request->input('ocupacion')));
            $terapia->enfpersistente = Str::upper(e($request->input('enfpersistente')));
            $terapia->hta = Str::upper(e($request->input('hta')));
            $terapia->dbt = Str::upper(e($request->input('dbt')));
            $terapia->colytri = Str::upper(e($request->input('colytri')));
            $terapia->dolart = Str::upper(e($request->input('dolart')));
            $terapia->dolmusc = Str::upper(e($request->input('dolmusc')));
            $terapia->cirujias = Str::upper(e($request->input('cirujias')));
            $terapia->osteoporosis = Str::upper(e($request->input('osteoporosis')));
            $terapia->motivo = Str::upper(e($request->input('motivo')));
            $terapia->tos = Str::upper(e($request->input('tos')));
            $terapia->espectoracion = Str::upper(e($request->input('espectoracion')));
            $terapia->sagita = Str::upper(e($request->input('sagita')));
            $terapia->muscresp = Str::upper(e($request->input('muscresp')));
            $terapia->musccuello = Str::upper(e($request->input('musccuello')));
            $terapia->muscabdom = Str::upper(e($request->input('muscabdom')));
            $terapia->capresp = Str::upper(e($request->input('capresp')));
            $terapia->efisglosa = Str::upper(e($request->input('efisglosa')));
            $terapia->emtono = Str::upper(e($request->input('emtono')));
            $terapia->emfuerza = Str::upper(e($request->input('emfuerza')));
            $terapia->objetivos = Str::upper(e($request->input('objetivos')));

    		if($terapia->save()):
    			return redirect('/admin/terapia/'.$terapia->id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getTerapiaEdit($id)
    {
        $terapia = Terapia::findOrFail($id);
        $detterapia = Detterapiaeval::where('terapia_id', $id)->get();
        $detterapia2 = Detterapiaeval2::where('terapia_id', $id)->get();
        $pacientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','id');
        $paciente = Paciente::findOrFail($terapia->paciente_id);
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $data = [
            'terapia' => $terapia,
            'detterapia' => $detterapia,
            'detterapia2' => $detterapia2,
            'pacientes' => $pacientes,
            'paciente' => $paciente,
            'doctor' => $doctor,
            'sexo' => $sexo
        ];
        return view('admin.terapias.edit', $data);
    }

    public function postTerapiaEdit(Request $request, $id)
    {
    	$rules = [
    		'razsoc' => 'required',
    		'fechaeval' => 'required'
    	];
    	$messages = [
    		'razsoc.required' => 'Ingrese paciente.',
    		'fechaeval.required' => 'Ingrese fecha de evaluación.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$terapia = Terapia::findOrFail($id);
            $terapia->paciente_id = $request->input('razsoc');
    		$terapia->diagnostico = Str::upper(e($request->input('diagnostico')));
            $terapia->hospitalizacion = $request->input('hospitalizacion');
            $terapia->hospfech = Str::upper(e($request->input('hospfech')));
            $terapia->hosplugar = Str::upper(e($request->input('hosplugar')));
            $terapia->hospalta = Str::upper(e($request->input('hospalta')));
            $terapia->fechaeval = $request->input('fechaeval');
            $terapia->altura = Str::upper(e($request->input('altura')));
            $terapia->peso = Str::upper(e($request->input('peso')));
            $terapia->pesoglosa = Str::upper(e($request->input('pesoglosa')));
            $terapia->fumador = $request->input('fumador');
            $terapia->fumcese = Str::upper(e($request->input('fumcese')));
            $terapia->spo2 = Str::upper(e($request->input('spo2')));
            $terapia->fc = Str::upper(e($request->input('fc')));
            $terapia->resxmin = Str::upper(e($request->input('resxmin')));
            $terapia->pa = Str::upper(e($request->input('pa')));
            $terapia->ocupacion = Str::upper(e($request->input('ocupacion')));
            $terapia->enfpersistente = Str::upper(e($request->input('enfpersistente')));
            $terapia->hta = Str::upper(e($request->input('hta')));
            $terapia->dbt = Str::upper(e($request->input('dbt')));
            $terapia->colytri = Str::upper(e($request->input('colytri')));
            $terapia->dolart = Str::upper(e($request->input('dolart')));
            $terapia->dolmusc = Str::upper(e($request->input('dolmusc')));
            $terapia->cirujias = Str::upper(e($request->input('cirujias')));
            $terapia->osteoporosis = Str::upper(e($request->input('osteoporosis')));
            $terapia->motivo = Str::upper(e($request->input('motivo')));
            $terapia->tos = Str::upper(e($request->input('tos')));
            $terapia->espectoracion = Str::upper(e($request->input('espectoracion')));
            $terapia->sagita = Str::upper(e($request->input('sagita')));
            $terapia->muscresp = Str::upper(e($request->input('muscresp')));
            $terapia->musccuello = Str::upper(e($request->input('musccuello')));
            $terapia->muscabdom = Str::upper(e($request->input('muscabdom')));
            $terapia->capresp = Str::upper(e($request->input('capresp')));
            $terapia->efisglosa = Str::upper(e($request->input('efisglosa')));
            $terapia->emtono = Str::upper(e($request->input('emtono')));
            $terapia->emfuerza = Str::upper(e($request->input('emfuerza')));
            $terapia->objetivos = Str::upper(e($request->input('objetivos')));

    		if($terapia->save()):
    			return redirect('/admin/terapias')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function postTerapiaAddEditDetItem(Request $request, $id)
    {
        $tipo = $request->input('tipitem');
        if($tipo == 1){
            $terapia = new Detterapiaeval;
            $terapia->terapia_id = $id;
        }else{
            $idi = $request->input('idi');
            $terapia = Detterapiaeval::findOrFail($id);;
        }
        $terapia->t = Str::upper(e($request->input('t')));
        $terapia->v = Str::upper(e($request->input('v')));
        $terapia->sao2 = Str::upper(e($request->input('sao2')));
        $terapia->fc = Str::upper(e($request->input('fc')));
        $terapia->actividad = Str::upper(e($request->input('actividad')));

        if($terapia->save()):
            return redirect('/admin/terapia/'.$id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');

        endif;

    }

    public function getTerapiaSearchItem(Request $request,$id)
    {
        if($request->ajax()){
            $det = Detterapiaeval::findOrFail($id);
            return response()->json($det);
        }
    }

    public function getTerapiaDeleteItem($id)
    {
        $det = Detterapiaeval::findOrFail($id);
        if($det->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function postTerapiaAddEditDetItem2(Request $request, $id)
    {
        $tipo = $request->input('tipitem');
        if($tipo == 1){
            $terapia = new Detterapiaeval2;
            $terapia->terapia_id = $id;
        }else{
            $idi = $request->input('idi');
            $terapia = Detterapiaeval2::findOrFail($id);;
        }
        $terapia->t = Str::upper(e($request->input('t')));
        $terapia->v = Str::upper(e($request->input('v')));
        $terapia->sao2 = Str::upper(e($request->input('sao2')));
        $terapia->fc = Str::upper(e($request->input('fc')));
        $terapia->actividad = Str::upper(e($request->input('actividad')));

        if($terapia->save()):
            return redirect('/admin/terapia/'.$id.'/edit')->with('message', 'Registro guardado')->with('typealert', 'success');

        endif;

    }

    public function getTerapiaSearchItem2(Request $request,$id)
    {
        if($request->ajax()){
            $det = Detterapiaeval2::findOrFail($id);
            return response()->json($det);
        }
    }

    public function getTerapiaDeleteItem2($id)
    {
        $det = Detterapiaeval2::findOrFail($id);
        if($det->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }
}
