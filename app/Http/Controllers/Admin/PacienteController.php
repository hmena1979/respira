<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Doctor;
use App\Http\Models\Correlativo;
use App\Http\Models\Historia;
use App\Http\Models\Param;
//use App\Http\Models\Cie10;
//use App\Http\Models\Diagnostico;

class PacienteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getPacienteHome()
    {
    	return view('admin.pacientes.home');
    }

    public function getPacienteRegistro()
    {
        return datatables()
            ->of(Paciente::select('id','historia','numdoc','razsoc','telefono')
                ->where('tipo', 1))
            ->addColumn('btn','admin.pacientes.action')
            ->rawColumns(['btn'])
            ->toJson();
        //return DataTables::of(Cie10::query())->make(true);
        //return datatables(Cie10::all())->toJson();
    }
    
    public function getPacienteAdd()
    {
        $tipdoc = Categoria::where('modulo', 0)->orderBy('codigo')->pluck('nombre','codigo');
        $tippac = Categoria::where('modulo', 1)->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');
        $doctor = Doctor::where('activo',1)->pluck('nombre','id');
        $data = [
            'tipdoc' => $tipdoc,
            'tippac' => $tippac,
            'sexo' => $sexo,
            'estciv' => $estciv,
            'doctor' => $doctor
        ];
        return view('admin.pacientes.add', $data);
    }

    public function postPacienteAdd(Request $request)
    {
        $tipo = $request->input('tipdoc_id');
        $numdoc = e($request->input('numdoc'));

        $pac = Paciente::Where('tipdoc_id',$tipo)->Where('numdoc',$numdoc)->count();
        if($pac > 0){
            return back()->with('message', 'Ya se encuentra registrado')->with('typealert', 'danger')->withinput();
        }

        $rules = [
    		'numdoc' => 'required',
            'fecnac' => 'required',
            'sexo_id' => 'required',
            'ape_pat' => 'required',
            'nombre1' => 'required',
            'estciv_id' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'tippac_id' => 'required'
    	];
    	$messages = [
    		'numdoc.required' => 'Ingrese número documento.',
    		'fecnac.required' => 'Ingrese fecha de nacimiento.',
            'sexo_id.required' => 'Selecione sexo.',
            'ape_pat.required' => 'Ingrese apellido.',
            'nombre1.required' => 'Ingrese nombre.',
            'estciv_id.required' => 'Selecione estado civil.',
            'fecha.required' => 'Ingrese fecha de la cita.',
            'hora.required' => 'Ingrese hora de la cita.',
            'tippac_id.required' => 'Ingrese tipo de paciente.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:

            $historia = strval(Correlativo::where('index','HISTORIA')->value('valor') + 1);
            $historia = str_pad($historia, 5, '0', STR_PAD_LEFT);
            $paciente = new Paciente;
            $paciente->historia = $historia;
            $paciente->tipdoc_id = $request->input('tipdoc_id');
            $paciente->numdoc = e($request->input('numdoc'));
            $paciente->fecnac = $request->input('fecnac');
            $paciente->sexo_id = $request->input('sexo_id');
            $paciente->estciv_id = $request->input('estciv_id');
            $paciente->ape_pat = Str::upper(e($request->input('ape_pat')));
            $paciente->ape_mat = Str::upper(e($request->input('ape_mat')));
            $paciente->nombre1 = Str::upper(e($request->input('nombre1')));
            $paciente->nombre2 = Str::upper(e($request->input('nombre2')));
            $paciente->razsoc = $paciente->ape_pat . ' ' . $paciente->ape_mat . ' ' . $paciente->nombre1 . ' ' . $paciente->nombre2;
            $paciente->direccion = Str::upper(e($request->input('direccion')));
            $paciente->email = e($request->input('email'));
            $paciente->telefono = e($request->input('telefono'));
            $paciente->ocupacion = Str::upper(e($request->input('ocupacion')));
            $paciente->lorigen = Str::upper(e($request->input('lorigen')));
            $paciente->lresidencia = Str::upper(e($request->input('lresidencia')));
            $paciente->responsable = Str::upper(e($request->input('responsable')));
            $paciente->doctor_id = e($request->input('doctor_id'));
            $paciente->tippac_id = e($request->input('tippac_id'));
            $fecha = e($request->input('fecha'));
            $hora = e($request->input('hora'));
            $tippac_id = $request->input('tippac_id');

            if($paciente->save()):
                $corr = Correlativo::where('index','HISTORIA')->update(['valor'=> intval($historia)]);
                Historia::insert([
                    'paciente_id'=>$paciente->id,
                    'doctor_id'=>$paciente->doctor_id,
                    'item'=>'001',
                    'tippac_id'=>$tippac_id,
                    'fecha'=>$fecha,
                    'hora'=>$hora
                    ]);
    			return redirect('/admin/pacientes')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getPacienteEdit(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $historia = Historia::where('paciente_id', $id)->where('item','001')->get();
        $tipdoc = Categoria::where('modulo', 0)->orderBy('codigo')->pluck('nombre','codigo');
        $tippac = Categoria::where('modulo', 1)->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');
        $doctor = Doctor::where('activo',1)->pluck('nombre','id');
        $data = [
            'paciente' => $paciente,
            'historia' => $historia,
            'tipdoc' => $tipdoc,
            'tippac' => $tippac,
            'sexo' => $sexo,
            'estciv' => $estciv,
            'doctor' => $doctor
        ];
        return view('admin.pacientes.edit', $data);
    }

    public function postPacienteEdit(Request $request, $id)
    {
        $rules = [
    		'numdoc' => 'required',
            'fecnac' => 'required',
            'sexo_id' => 'required',
            'ape_pat' => 'required',
            'nombre1' => 'required',
            'estciv_id' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'tippac_id' => 'required'
    	];
    	$messages = [
    		'numdoc.required' => 'Ingrese número documento.',
    		'fecnac.required' => 'Ingrese fecha de nacimiento.',
            'sexo_id.required' => 'Selecione sexo.',
            'ape_pat.required' => 'Ingrese apellido.',
            'nombre1.required' => 'Ingrese nombre.',
            'estciv_id.required' => 'Selecione estado civil.',
            'fecha.required' => 'Ingrese fecha de la cita.',
            'hora.required' => 'Ingrese hora de la cita.',
            'tippac_id.required' => 'Ingrese tipo de paciente.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $paciente = Paciente::findOrFail($id);
            $paciente->tipdoc_id = $request->input('tipdoc_id');
            $paciente->numdoc = e($request->input('numdoc'));
            $paciente->fecnac = $request->input('fecnac');
            $paciente->sexo_id = $request->input('sexo_id');
            $paciente->estciv_id = $request->input('estciv_id');
            $paciente->ape_pat = Str::upper(e($request->input('ape_pat')));
            $paciente->ape_mat = Str::upper(e($request->input('ape_mat')));
            $paciente->nombre1 = Str::upper(e($request->input('nombre1')));
            $paciente->nombre2 = Str::upper(e($request->input('nombre2')));
            $paciente->razsoc = $paciente->ape_pat . ' ' . $paciente->ape_mat . ' ' . $paciente->nombre1 . ' ' . $paciente->nombre2;
            $paciente->direccion = Str::upper(e($request->input('direccion')));
            $paciente->email = e($request->input('email'));
            $paciente->telefono = e($request->input('telefono'));
            $paciente->ocupacion = Str::upper(e($request->input('ocupacion')));
            $paciente->lorigen = Str::upper(e($request->input('lorigen')));
            $paciente->lresidencia = Str::upper(e($request->input('lresidencia')));
            $paciente->responsable = Str::upper(e($request->input('responsable')));
            $paciente->doctor_id = e($request->input('doctor_id'));
            $paciente->tippac_id = e($request->input('tippac_id'));
            $fecha = e($request->input('fecha'));
            $hora = e($request->input('hora'));
            $tippac_id = $request->input('tippac_id');

            if($paciente->save()):
                $his = Historia::where('paciente_id',$id)
                    ->where('item','001')
                    ->update([
                        'doctor_id'=>$paciente->doctor_id,
                        'tippac_id'=>$tippac_id,
                        'fecha'=>$fecha,
                        'hora'=>$hora
                    ]);
    			return redirect('/admin/pacientes')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function postPacientePast(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $antecedentes = [
			'dm' => $request->input('dm'),
            'hta' => $request->input('hta'),
            'neumonia' => $request->input('neumonia'),
            'tbc' => $request->input('tbc'),
            'asma' => $request->input('asma'),
            'tabaco' => $request->input('tabaco'),
            'covid19' => $request->input('covid19'),
            'ehlc' => $request->input('ehlc')
        ];
        $alergia = [
			'polvo' => $request->input('polvo'),
            'humedad' => $request->input('humedad'),
            'polen' => $request->input('polen'),
            'medicamentos' => $request->input('medicamentos'),
            'desotros' => Str::upper(e($request->input('desotros')))
        ];
        $antecedentes = json_encode($antecedentes);
        $alergia = json_encode($alergia);
        $paciente->antecedentes = $antecedentes;
        $paciente->alergia = $alergia;
        $paciente->tie_enfer = Str::upper(e($request->input('tie_enfer')));
        $paciente->tenfact = Str::upper(e($request->input('tenfact')));
        if($paciente->save()):
            return redirect('/admin/historias/'.$id.'/001/home')->with('message', 'Antecedentes actualizados')->with('typealert', 'success');
        else:
            return back()->withErrors($validator)->with('message', 'No se actualizó el registro')->withinput();
        endif;
    }

    public function getPacienteAppointment($id)
    {
        $paciente = Paciente::findOrFail($id);
        $doctor = Doctor::where('activo',1)->pluck('nombre','id');
        $tippac = Categoria::where('modulo', 1)->pluck('nombre','codigo');
        $tipo = Categoria::where('modulo', 13)->pluck('nombre','codigo');
        $data = [
            'doctor' => $doctor,
            'paciente' => $paciente,
            'tippac' => $tippac,
            'tipo' => $tipo
        ];
        return view('admin.pacientes.appointment', $data);
    }

    public function postPacienteAppointment(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha de la próxima cita.'
            
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $uitem = Historia::Where('paciente_id', $id)->orderBy('item', 'desc')->take(1)->value('item');
            $uitem = str_pad(intval($uitem)+1, 3, '0', STR_PAD_LEFT);
            $c = Historia::Where('paciente_id', $id)->Where('fecha', $request->input('fecha'))->value('id');
            if($c<>''){
                $h = Historia::findOrFail($c);
                $h->paciente_id = $id;
                $h->item = $uitem;
                $h->tipo =  $request->input('tipo');
                $h->doctor_id = $request->input('doctor_id');
                $h->fecha = $request->input('fecha');//\Carbon\Carbon::now();
                $h->hora = $request->input('hora');
                $h->tippac_id = $request->input('tippac_id');
                if($h->save()):
                    return redirect('/admin/pacientes')->with('message', 'Registro actualizado')->with('typealert', 'success');
                endif;

                // return back()->with('message', 'Ya existe una consulta creada para este dia')->with('typealert', 'danger')->withinput();
            }

            $h = new Historia;
            $h->paciente_id = $id;
            $h->item = $uitem;
            $h->tipo =  $request->input('tipo');
            $h->doctor_id = $request->input('doctor_id');
            $h->fecha = $request->input('fecha');//\Carbon\Carbon::now();
            $h->hora = $request->input('hora');
            $h->tippac_id = $request->input('tippac_id');
            $h->status = 1;
            if($h->save()):
                return redirect('/admin/pacientes')->with('message', 'Cita creada')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getPacienteBusApi($tipo, $numero)
    {
        $parametro = Param::findOrFail(1);
        $token = $parametro->apitoken;
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true),
        ));
        if($tipo=='1'){
            $api = file_get_contents('https://dniruc.apisperu.com/api/v1/dni/'.$numero.'?token='.$token,false,$context);

        }else{
            $api = file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/'.$numero.'?token='.$token,false,$context);
        }
        if($api == false){
            return 0;
        }else{
            $api = str_replace('&Ntilde;','Ñ',$api);
            $api = json_decode($api);
            return response()->json($api);
            //return $api;
        }
    }

    public function getPacienteBusDNI($tipo, $numero)
    {
        $pac = Paciente::Where('tipdoc_id',$tipo)->Where('numdoc',$numero)->count();
        if($pac > 0){
            return 0;
        }else{
            return 1;
        }
    }

}
