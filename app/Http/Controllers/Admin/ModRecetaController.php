<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Modreceta;
use App\Http\Models\DetModreceta;
use App\Http\Models\Producto;
use App\Http\Models\Categoria;
use App\Http\Models\Umedida;

class ModRecetaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getModRecetaHome()
    {
        $modrecetas = Modreceta::get();
        $data = [
            'modrecetas'=>$modrecetas
        ];
        return view('admin.modrecetas.home', $data);
    }

    public function getModRecetaAdd()
    {
        return view('admin.modrecetas.add');
    }

    public function postModRecetaAdd(Request $request)
    {
        $rules = [
    		'nombre' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $c = new Modreceta;
            $c->nombre = Str::upper(e($request->input('nombre')));
            $c->activo = e($request->input('activo'));

    		if($c->save()):
    			return redirect('/admin/modreceta/'.$c->id.'/deta')->with('message', 'Registro guardado, ingrese detalles de la receta')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getModRecetaDetAdd($id)
    {
        $modreceta = Modreceta::findOrFail($id);
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $posmed = Categoria::where('modulo', 7)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $posfre = Categoria::where('modulo', 8)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $postie = Categoria::where('modulo', 9)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $data = [
            'modreceta' => $modreceta,
            'umedida' => $umedida,
            'posmed' => $posmed,
            'posfre' => $posfre,
            'postie' => $postie
        ];
        return view('admin.modrecetas.deta', $data);
    }

    public function postModRecetaDetAdd(Request $request, $id)
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
            $r = new DetModreceta;
            $r->modreceta_id = $id;
            $r->producto_id = $request->input('producto_id');
            $r->nombre = Str::upper(e($request->input('nombre')));
            $r->umedida_id = e($request->input('umedida_id'));
            $r->cantidad = e($request->input('cantidad'));
            $r->posologia = e($request->input('posologia'));
            $r->posmed_id = e($request->input('posmed_id'));
            $r->posfrec_id = e($request->input('posfrec_id'));
            $r->postie = Str::upper(e($request->input('postie')));
            $r->postie_id = e($request->input('postie_id'));
            $r->recomendacion = Str::upper(e($request->input('recomendacion')));
            if($r->save()):
                return redirect('/admin/modreceta/'.$id.'/edit')->with('message', 'Registro agregado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getModRecetaDetEdit($id)
    {
        $detmodreceta = DetModreceta::findOrFail($id);
        $modreceta = Modreceta::findOrFail($detmodreceta->modreceta_id);
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $posmed = Categoria::where('modulo', 7)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $posfre = Categoria::where('modulo', 8)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $postie = Categoria::where('modulo', 9)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $data = [
            'detmodreceta' => $detmodreceta,
            'modreceta' => $modreceta,
            'umedida' => $umedida,
            'posmed' => $posmed,
            'posfre' => $posfre,
            'postie' => $postie
        ];
        return view('admin.modrecetas.dete', $data);
    }

    public function postModRecetaDetEdit(Request $request, $id)
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
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $r = DetModreceta::findOrFail($id);
            $r->producto_id = $request->input('producto_id');
            $r->nombre = Str::upper(e($request->input('nombre')));
            $r->umedida_id = e($request->input('umedida_id'));
            $r->cantidad = e($request->input('cantidad'));
            $r->posologia = e($request->input('posologia'));
            $r->posmed_id = e($request->input('posmed_id'));
            $r->posfrec_id = e($request->input('posfrec_id'));
            $r->postie = Str::upper(e($request->input('postie')));
            $r->postie_id = e($request->input('postie_id'));
            $r->recomendacion = Str::upper(e($request->input('recomendacion')));
            if($r->save()):
                return redirect('/admin/modreceta/'.$r->modreceta_id.'/edit')->with('message', 'Registro agregado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getModRecetaEdit($id)
    {
        $modreceta = Modreceta::findOrFail($id);
        $detmodrecetas = DetModreceta::with(['um','pmed','pfre','ptie'])->where('modreceta_id', $id)->get();
        $umedida = Umedida::orderBy('nombre')->pluck('nombre','id');
        $posmed = Categoria::where('modulo', 7)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $posfre = Categoria::where('modulo', 8)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $postie = Categoria::where('modulo', 9)->orWhere('modulo',12)->orderBy('nombre')->pluck('nombre','codigo');
        $data = [
            'modreceta' => $modreceta,
            'detmodrecetas' => $detmodrecetas,
            'umedida' => $umedida,
            'posmed' => $posmed,
            'posfre' => $posfre,
            'postie' => $postie
        ];
        return view('admin.modrecetas.edit', $data);
    }

    public function postModRecetaEdit(Request $request, $id)
    {
        $rules = [
    		'nombre' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
            $c = Modreceta::findOrFail($id);
            $c->nombre = Str::upper(e($request->input('nombre')));
            $c->activo = e($request->input('activo'));

    		if($c->save()):
    			return redirect('/admin/modrecetas')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getModRecetaDetDelete($id){
    	$c = DetModreceta::findOrFail($id);
    	if($c->delete()):
			return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }

    public function getModRecetaDelete($id){
        $modreceta = Modreceta::findOrFail($id);
        $detmodrecetas = DetModreceta::where('modreceta_id', $id)->count();
        if($detmodrecetas > 0){
            return back()->with('message', 'Registro no puede ser eliminado, contiene detalles')->with('typealert', 'danger');
        }
    	if($modreceta->delete()){
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        }
    }
}
