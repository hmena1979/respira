<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Auth;

use Storage;

use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Doctor;
use App\Http\Models\Correlativo;
use App\Http\Models\Historia;
use App\Http\Models\Cie10;
use App\Http\Models\Diagnostico;
use App\Http\Models\Receta;
use App\Http\Models\Umedida;
use App\Http\Models\Modreceta;
use App\Http\Models\DetModreceta;
use App\Http\Models\Examen;


class HistoriaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getHistoriaHome($id, $item)
    {
        //$paciente = Paciente::findOrFail($id);
        $paciente = Paciente::with(['his'])->findOrFail($id);
        //$historias = Historia::where('paciente_id', $id)->get();
        $historia1 = Historia::where('paciente_id', $id)->where('item', $item)->get();
        //$historia_id = Historia::where('paciente_id', $id)->where('item', $item)->value('id');
        if($item == 'E'){
            $exa = 1;
        }
        else{
            $exa = 2;
        }

        
        if($historia1->count() == 0){
            $historia1 = Historia::where('paciente_id', $id)->get();
            $item = $historia1[0]->item;
            $historia1 = Historia::where('paciente_id', $id)->where('item', $item)->get();
        }
        if($paciente->his->count()>0 && $item <> 'E'):
            $historia_id = $historia1[0]->id;
        else:
            $historia_id = '';
        endif;
        
        $doctor = Doctor::where('activo',1)->orderBy('nombre')->pluck('nombre','id');
        $cie10s = Cie10::pluck('nombre','codigo');
        $diagnosticos = Diagnostico::with(['cie','tip','vis'])->where('historia_id', $historia_id)->get();
        $tipod = Categoria::where('modulo', 5)->orderBy('codigo')->pluck('nombre','codigo');
        $visitad = Categoria::where('modulo', 6)->orderBy('codigo')->pluck('nombre','codigo');
        $recetas = Receta::with(['um','pmed','pfre','ptie'])->where('historia_id', $historia_id)->get();
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $posmed = Categoria::where('modulo', 7)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $posfre = Categoria::where('modulo', 8)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $postie = Categoria::where('modulo', 9)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $tipo = Categoria::where('modulo', 13)->orderBy('nombre')->pluck('nombre','codigo');
        $modreceta = Modreceta::orderBy('nombre')->pluck('nombre','id');
        $examen = Examen::where('paciente_id', $id)->get();
        $data = [
            'paciente' => $paciente,
            'historia1' => $historia1,
            'item' => $item,
            'doctor' => $doctor,
            'cie10s' => $cie10s,
            'diagnosticos' => $diagnosticos,
            'tipod' => $tipod,
            'visitad' => $visitad,
            'recetas' => $recetas,
            'umedida' => $umedida,
            'posmed' => $posmed,
            'posfre' => $posfre,
            'postie' => $postie,
            'tipo' => $tipo,
            'exa' => $exa,
            'modreceta' => $modreceta,
            'examen' => $examen
        ];
        if(!session('pagina')):
            session(['pagina' => "uno"]);
        endif;
        return view('admin.historias.home', $data);
    }

    public function getHistoriaTriage($id)
    {
        $historia = Historia::with(['pac'])->findOrFail($id);
        $doctor = Doctor::where('activo',1)->pluck('nombre','id');
        $data = [
            'historia' => $historia,
            'doctor' => $doctor
        ];
        return view('admin.historias.triage', $data);
    }

    public function postHistoriaTriage(Request $request, $id)
    {
        $h = Historia::findOrFail($id);
        $h->peso = Str::upper(e($request->input('peso')));
        $h->talla = Str::upper(e($request->input('talla')));
        $h->temp = Str::upper(e($request->input('temp')));
        $h->fc = Str::upper(e($request->input('fc')));
        $h->fr = Str::upper(e($request->input('fr')));
        $h->sato2 = Str::upper(e($request->input('sato2')));
        $h->pa = Str::upper(e($request->input('pa')));
        if($h->status === 1):
            $h->status = 2;
        endif;
        if($h->save()):
            return redirect('/admin')->with('message', 'Registro guardado')->with('typealert', 'success');
        endif;
    }

    public function postHistoriaNew(Request $request, $id)
    {
        $h = new Historia;
        $h->paciente_id = $id;
        $h->item = '001';
        if($request->input('doctor_id') === 1):
            $h->doctor_id = Auth::user()->doctor_id;
        else:
            $h->doctor_id = $request->input('doctor_id');
        endif;
        $h->doctor_id = $request->input('doctor_id');
        $h->fecha = $request->input('fecha');//\Carbon\Carbon::now();
        $h->hora = $request->input('hora');
        $h->peso = Str::upper(e($request->input('peso')));
        $h->talla = Str::upper(e($request->input('talla')));
        $h->temp = Str::upper(e($request->input('temp')));
        $h->fc = Str::upper(e($request->input('fc')));
        $h->fr = Str::upper(e($request->input('fr')));
        $h->sato2 = Str::upper(e($request->input('sato2')));
        $h->pa = Str::upper(e($request->input('pa')));
        $h->anammesis = Str::upper(e($request->input('anammesis')));
        $h->evolucion = Str::upper(e($request->input('evolucion')));
        $h->antecedentes = Str::upper(e($request->input('antecedentes')));
        $h->exafisico = Str::upper(e($request->input('exafisico')));
        $h->status = 3;
        session(['pagina' => "uno"]); 
        if($h->save()):
            return redirect('/admin/historias/'.$id.'/'.$h->item.'/home')->with('message', 'Registro guardado')->with('typealert', 'success');

        endif;
    }

    public function postHistoriaEdit(Request $request, $id)
    {
        $h = Historia::findOrFail($id);
        if($request->input('doctor_id') == 1):
            $h->doctor_id = Auth::user()->doctor_id;
        else:
            $h->doctor_id = $request->input('doctor_id');
        endif;
        $h->fecha = $request->input('fecha');//\Carbon\Carbon::now(); 
        $h->hora = $request->input('hora');
        $h->peso = Str::upper(e($request->input('peso')));
        $h->talla = Str::upper(e($request->input('talla')));
        $h->temp = Str::upper(e($request->input('temp')));
        $h->fc = Str::upper(e($request->input('fc')));
        $h->fr = Str::upper(e($request->input('fr')));
        $h->sato2 = Str::upper(e($request->input('sato2')));
        $h->pa = Str::upper(e($request->input('pa')));
        $h->anammesis = Str::upper(e($request->input('anammesis')));
        $h->evolucion = Str::upper(e($request->input('evolucion')));
        $h->antecedentes = Str::upper(e($request->input('antecedentes')));
        $h->exafisico = Str::upper(e($request->input('exafisico')));
        $h->status = 3;
        session(['pagina' => "uno"]); 
        if($h->save()):
            return redirect('/admin/historias/'.$h->paciente_id.'/'.$h->item.'/home')->with('message', 'Registro guardado')->with('typealert', 'success');
        endif;
    }

    public function postHistoriaPlan(Request $request, $id)
    {
        $h = Historia::findOrFail($id);
        $h->plantera = Str::upper(e($request->input('plantera')));
        $radtorax = [
			'senpar' => $request->input('senpar'),
			'cavum' => $request->input('cavum'),
			'torax' => $request->input('torax'),
			'parrcostal' => $request->input('parrcostal'),
			'1incidencia' => $request->input('1incidencia'),
			'frontal' => $request->input('frontal'),
			'lateral' => $request->input('lateral'),
			'2incidencia' => $request->input('2incidencia'),
            'otpradio' => Str::upper(e($request->input('otpradio'))),
			'ecografia' => $request->input('ecografia'),
            'ecotex' => Str::upper(e($request->input('ecotex'))),
            'dpresuntivo' => Str::upper(e($request->input('dpresuntivo'))),
            'dclinico' => Str::upper(e($request->input('dclinico')))
        ];
        $h->radtorax = json_encode($radtorax);
        
        $tomografia = [
			'ccontraste' => $request->input('ccontraste'),
			'scontraste' => $request->input('scontraste'),
			'sparanasal' => $request->input('sparanasal'),
			'cuello' => $request->input('cuello'),
			'ttorax' => $request->input('ttorax'),
			'tpm' => $request->input('tpm'),
			'tar' => $request->input('tar'),
			'ptpc' => $request->input('ptpc'),
			'vas3d' => $request->input('vas3d'),
			'angiotem' => $request->input('angiotem'),
			'toraxico' => $request->input('toraxico'),
            'otptomografia' => Str::upper(e($request->input('otptomografia')))
        ];
        $h->tomografia = json_encode($tomografia);
        
        $espirometria = [
			'esimple' => $request->input('esimple'),
			'emb' => $request->input('emb'),
			'tc' => $request->input('tc'),
			'on' => $request->input('on'),
			'pmd' => $request->input('pmd'),
			'flujo' => $request->input('flujo'),
            'opruebas' => Str::upper(e($request->input('opruebas')))
        ];
        $h->espirometria = json_encode($espirometria);

        $h->anotaciones = Str::upper(e($request->input('anotaciones')));
        $h->status = 3;
        session(['pagina' => "tres"]);        
        if($h->save()):
            return redirect('/admin/historias/'.$h->paciente_id.'/'.$h->item.'/home')->with('message', 'Plan terapeutico actualizado')->with('typealert', 'success');
        endif;
    }

    public function postHistoriaDiagnosisAdd(Request $request, $id)
    {
        $rules = [
    		'cie10_id' => 'required',
    		'tipo_id' => 'required',
    		'visita_id' => 'required'
    	];
    	$messages = [
    		'cie10_id.required' => 'Ingrese CIE 10.',
    		'tipo_id.required' => 'Ingrese tipo.',
    		'visita_id.required' => 'Ingrese visita.'
        ];
        
        $cie10s = Cie10::where('codigo',e($request->input('cie10_id')))->get();
        if($cie10s->count() == 0){
            session(['pagina' => "dos"]);
    		return back()->with('message', 'Se ha producido un error, CIE10 no existe')->with('typealert', 'danger')->withinput(); 
        }

    	$validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
            session(['pagina' => "dos"]);
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $d = new Diagnostico;
            $d->historia_id = $id;
            $d->cie10_id = Str::upper(e($request->input('cie10_id')));
            $d->tipo_id = e($request->input('tipo_id'));
            $d->visita_id = e($request->input('visita_id'));
            session(['pagina' => "dos"]);
            if($d->save()):
                return redirect('/admin/historias/'.$request->input('paciente_id').'/'.$request->input('item').'/home')->with('message', 'Diagnóstico agregado')->with('typealert', 'success');
            endif;
        endif;

    }

    public function getHistoriaDiagnosisDelete($id)
    {
        $d = Diagnostico::findOrFail($id);
        session(['pagina' => "dos"]); 
        if($d->delete()):
            return back()->with('message', 'Diagnóstico eliminado')->with('typealert', 'success');
        endif;
    }

    public function postHistoriaPrescriptionAdd(Request $request, $id)
    {
        $rules = [
    		'nombre' => 'required',
    		'umedida_id' => 'required',
    		'cantidad' => 'required',
    		'posmed_id' => 'required',
    		'posfrec_id' => 'required',
    		'postie_id' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre del medicamento.',
    		'umedida_id.required' => 'Ingrese presentación.',
    		'cantidad.required' => 'Ingrese cantidad.',
    		'posmed_id.required' => 'Ingrese posología.',
    		'posfrec_id.required' => 'Ingrese posología.',
    		'postie_id.required' => 'Ingrese tiempo.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
            session(['pagina' => "cuatro"]);
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            if($request->input('tipitem') == 1){
                $r = new Receta;
                $r->historia_id = $id;
            }else{
                $r = Receta::findOrFail($request->input('receta_id'));
            }
            $r->producto_id = $request->input('producto_id');
            $r->nombre = Str::upper(e($request->input('nombre')));
            $r->composicion = Str::upper(e($request->input('composicion')));
            $r->umedida_id = e($request->input('umedida_id'));
            $r->cantidad = e($request->input('cantidad'));
            $r->posologia = e($request->input('posologia'));
            $r->posmed_id = e($request->input('posmed_id'));
            $r->posfrec_id = e($request->input('posfrec_id'));
            $r->postie = Str::upper(e($request->input('postie')));
            $r->postie_id = e($request->input('postie_id'));
            $r->recomendacion = Str::upper(e($request->input('recomendacion')));
            session(['pagina' => "cuatro"]);
            if($r->save()):
                return redirect('/admin/historias/'.$request->input('paciente_id').'/'.$request->input('item').'/home')->with('message', 'Registro agregado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function postHistoriaPrescriptionGen(Request $request,$id)
    {
        $modreceta = $request->input('modreceta');
        $detmodreceta = DetModreceta::where('modreceta_id',$request->input('modreceta'))->get();
        foreach($detmodreceta as $det){
            Receta::insert([
                'historia_id'=>$id,
                'producto_id'=>$det->producto_id,
                'nombre'=>$det->nombre,
                'composicion'=>$det->composicion,
                'umedida_id'=>$det->umedida_id,
                'cantidad'=>$det->cantidad,
                'posologia'=>$det->posologia,
                'posmed_id'=>$det->posmed_id,
                'posfrec_id'=>$det->posfrec_id,
                'postie'=>$det->postie,
                'postie_id'=>$det->postie_id,
                'recomendacion'=>$det->recomendacion
                ]);
        }
        session(['pagina' => "cuatro"]);
        return redirect('/admin/historias/'.$request->input('paciente_id').'/'.$request->input('item').'/home')->with('message', 'Receta agregada')->with('typealert', 'success');
    }

    public function getHistoriaSearchPrescription(Request $request,$id)
    {
        if($request->ajax()){
            $receta = Receta::findOrFail($id);
            return response()->json($receta);
        }
    }

    public function getHistoriaPrescriptionDelete($id)
    {
        $d = Receta::findOrFail($id);
        session(['pagina' => "cuatro"]); 
        if($d->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function postHistoriaPrescriptionFooter(Request $request, $id)
    {
        $h = Historia::findOrFail($id);
        $receta = [
			'rbt' => $request->input('rbt'),
            'rotros' => Str::upper(e($request->input('rotros'))),
            'efrio' => $request->input('efrio'),
            'epolvo' => $request->input('epolvo'),
            'ehumo' => $request->input('ehumo'),
            'ecitricos' => $request->input('ecitricos'),
            'eenvasados' => $request->input('eenvasados'),
            'eanimales' => $request->input('eanimales'),
            'ecolorantes' => $request->input('ecolorantes'),
            'eotros' => Str::upper(e($request->input('eotros')))
        ];
        $receta = json_encode($receta);
        $h->receta = $receta;
        session(['pagina' => "cuatro"]);
        if($h->save()):
            return redirect('/admin/historias/'.$h->paciente_id.'/'.$h->item.'/home')->with('message', 'Registro actualizado')->with('typealert', 'success');
        else:
            return back()->withErrors($validator)->with('message', 'No se actualizó el registro')->withinput();
        endif;
    }

    public function postHistoriaCita(Request $request, $id, $item)
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
            $uitem = str_pad(intval($item)+1, 3, '0', STR_PAD_LEFT);
            $c = Historia::Where('paciente_id', $id)->Where('fecha', $request->input('fecha'))->count();
            if($c<>0){
                return back()->with('message', 'Ya existe una consulta creada para este dia')->with('typealert', 'danger')->withinput();
            }
            $pf = Historia::where('paciente_id', $id)
                ->where('item', $item)
                ->value('pfecha');
            if($pf==null){
                $hi = Historia::where('paciente_id', $id)
                    ->where('item', $item)
                    ->update([
                        'ptipo' => $request->input('tipo'),
                        'pfecha' => $request->input('fecha')
                        ]);
                $h = new Historia;
                $h->paciente_id = $id;
                $h->item = $uitem;
                $h->doctor_id = $request->input('doctor_id');
                $h->fecha = $request->input('fecha');//\Carbon\Carbon::now();
                $h->tipo = $request->input('tipo');
                $h->status = 1;
                session(['pagina' => "cinco"]); 
                if($h->save()):
                    return redirect('/admin/historias/'.$id.'/'.$item.'/home')->with('message', 'Consulta creada')->with('typealert', 'success');
                endif;
            }else{
                $hi = Historia::where('paciente_id', $id)
                ->where('item', $item)
                ->update([
                    'ptipo' => $request->input('tipo'),
                    'pfecha' => $request->input('fecha')
                    ]);
                $hi = Historia::where('paciente_id', $id)
                ->where('fecha', $pf)
                ->update([
                    'tipo' => $request->input('tipo'),
                    'fecha' => $request->input('fecha')
                    ]);
                    session(['pagina' => "cinco"]); 
                    }
                endif;
                return redirect('/admin/historias/'.$id.'/'.$item.'/home')->with('message', 'Fecha actualizada')->with('typealert', 'success');
    }

    public function getHistoriaChange($id)
    {
        $historia = Historia::findOrFail($id);
        $paciente = Paciente::findOrFail($historia->paciente_id);
        if(Auth::user()->doctor_id === 1){
            $doctor = Doctor::where('activo',1)->pluck('nombre','id');
        }else{
            $doctor = Doctor::where('activo',1)->where('id', Auth::user()->doctor_id)->pluck('nombre','id');
        }
        $tippac = Categoria::where('modulo', 1)->pluck('nombre','codigo');
        $tipo = Categoria::where('modulo', 13)->pluck('nombre','codigo');
        $data = [
            'historia' => $historia,
            'doctor' => $doctor,
            'paciente' => $paciente,
            'tippac' => $tippac,
            'tipo' => $tipo
        ];
        return view('admin.historias.change', $data);
    }

    public function postHistoriaChange(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.'
            
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $h = Historia::findOrFail($id);
            $h->fecha = $request->input('fecha');
            $h->doctor_id = $request->input('doctor_id');
            $h->tipo =  $request->input('tipo');
            $h->tippac_id = $request->input('tippac_id');
            if($h->save()):
                return redirect('/admin')->with('message', 'Registro actualizado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function postHistoriaExamenAdd(Request $request, $id)
    {
        $rules = [
    		'fecha' => 'required',
    		'tipo' => 'required',
    		'imagen' => 'required',
    		'resultado' => 'required'
    	];
    	$messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'tipo.required' => 'Ingrese tipo',
    		'imagen.required' => 'Ingrese Imagen/Documento',
    		'resultado.required' => 'Ingrese resultado'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$fileExt = trim($request->file('imagen')->getClientOriginalExtension());
    		$name = Str::slug(str_replace($fileExt, '', $request->file('imagen')->getClientOriginalName()));
    		$archivo = rand(1,999).$name.'.'.$fileExt;
            $archivo = $id.'/'.$archivo;
            $content = $request->file('imagen');
            Storage::disk('examenes')->makeDirectory($id);
            $abc = Storage::disk('examenes')->put($id, $content);
            $examen = new Examen;
            $examen->paciente_id = $id;
            $examen->fecha = Str::upper(e($request->input('fecha')));
            $examen->tipo = Str::upper(e($request->input('tipo')));
            $examen->ruta = $abc;
            $examen->resultado = Str::upper(e($request->input('resultado')));
            if($examen->save()):
                
                
    			return redirect('/admin/historias/'.$id.'/E/home')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;


        endif;
    }

    public function getHistoriaExamenDelete($id)
    {
        $d = Examen::findOrFail($id);
        $ruta = $d->ruta;
        if($d->delete()):
            Storage::disk('examenes')->delete($ruta);
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function getHistoriaDelete($id)
    {
        $d = Historia::findOrFail($id);
        if($d->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

}
