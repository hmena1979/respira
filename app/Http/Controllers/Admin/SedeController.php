<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Config;
use Storage;

use App\Http\Models\Sede;
use App\Http\Models\Sedgaleria;


class SedeController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getSedeHome()
    {
    	$sed = Sede::orderBy('orden')->get();
    	$data = [
            'sed'=>$sed
        ];
    	return view('admin.sedes.home', $data);
    }

    public function getSedeAdd()
    {
    	$sed = Sede::get();
    	$data = [
            'sed'=>$sed
        ];
    	return view('admin.sedes.add', $data);
    }

    public function postSedeAdd(Request $request)
    {
        $reg = Sede::count();
    	$rules = [
    		'nombre' => 'required',
    		'lugar' => 'required',
    		'direccion' => 'required',
    		'img_princ' => 'required',
    		'img_sede' => 'required',
    		'telef1' => 'required',
    		'telef2' => 'required',
    		'email' => 'required',
    		'ubicacion' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'lugar.required' => 'Ingrese lugar.',
    		'direccion.required' => 'Ingrese dirección.',
    		'referencia.required' => 'Ingrese referencia.',
    		'ciudad.required' => 'Ingrese ciudad.',
    		'img_princ.required' => 'Seleccione una imagen principal.',
    		'img_sede.required' => 'Seleccione una imagen para el encabezado de la sede.',
    		'telef1.required' => 'Ingrese teléfono.',
    		'telef2.required' => 'Ingrese número para consultas.',
    		'email.required' => 'Ingrese correo electrónico.',
    		'ubicacion.required' => 'Ingrese ubicación Google Maps.'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		// $path = '/'.'sed';
    		// $fileExtP = trim($request->file('img_princ')->getClientOriginalExtension());
    		// $fileExtS = trim($request->file('img_sede')->getClientOriginalExtension());

    		// $upload_path = Config::get('filesystems.disks.uploads.root');
    		// $nameP = Str::slug(str_replace($fileExtP, '', $request->file('img_princ')->getClientOriginalName()));
    		// $nameS = Str::slug(str_replace($fileExtS, '', $request->file('img_sede')->getClientOriginalName()));
    		// $filenameP = rand(1,999).$nameP.'.'.$fileExtP;
    		// $filenameS = rand(1,999).$nameS.'.'.$fileExtS;
            $contentP = $request->file('img_princ');
            $contentS = $request->file('img_sede');
            Storage::disk('web')->makeDirectory('sed');
            $archivoP = Storage::disk('web')->put('esp', $contentP);
            $archivoS = Storage::disk('web')->put('esp', $contentS);
    		$c = new Sede;

    		$c->nombre = e($request->input('nombre'));
    		$c->lugar = e($request->input('lugar'));
    		$c->direccion = e($request->input('direccion'));
    		$c->referencia = e($request->input('referencia'));
    		$c->ciudad = e($request->input('ciudad'));
    		$c->img_princ = $archivoP;
    		$c->img_sede = $archivoS;
    		$c->telef1 = e($request->input('telef1'));
    		$c->telef2 = e($request->input('telef2'));
    		$c->email = e($request->input('email'));
    		$c->ubicacion = e($request->input('ubicacion'));
    		$c->activo = e($request->input('activo'));
            $c->orden = $reg + 1;
    		if($c->save()):
    			// if($request->hasFile('img_princ')):
    			// 	$f1 = $request->img_princ->storeAs($path, $filenameP, 'uploads');
    			// endif;
    			// if($request->hasFile('img_sede')):
    			// 	$f1 = $request->img_sede->storeAs($path, $filenameS, 'uploads');
    			// endif;
    			return redirect('/admin/web/sedes')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getSedeEdit($id)
    {
        $sed = Sede::findorFail($id);
        $data = [
            'sed'=>$sed
        ];
        return view('admin.sedes.edit', $data);
    }

    public function postSedeEdit($id, Request $request)
    {
        $rules = [
    		'nombre' => 'required',
    		'lugar' => 'required',
    		'direccion' => 'required',
    		'telef1' => 'required',
    		'telef2' => 'required',
    		'email' => 'required',
    		'ubicacion' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'lugar.required' => 'Ingrese lugar.',
    		'direccion.required' => 'Ingrese dirección.',
    		'referencia.required' => 'Ingrese referencia.',
    		'ciudad.required' => 'Ingrese ciudad.',
    		'img_princ.required' => 'Seleccione una imagen principal.',
    		'img_sede.required' => 'Seleccione una imagen para el encabezado de la sede.',
    		'telef1.required' => 'Ingrese teléfono.',
    		'telef2.required' => 'Ingrese número para consultas.',
    		'email.required' => 'Ingrese correo electrónico.',
    		'ubicacion.required' => 'Ingrese ubicación Google Maps.'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$path = '/'.'sed';
    		$c = Sede::find($id);
            if($request->hasFile('img_princ')):
                $ruta = $c->img_princ;
                Storage::disk('web')->delete($ruta);

                $contentP = $request->file('img_princ');
                $archivoP = Storage::disk('web')->put('sed', $contentP);
                $c->img_princ = $archivoP;
            endif;
            if($request->hasFile('img_sede')):
                $ruta = $c->img_sede;
                Storage::disk('web')->delete($ruta);

                $contentS = $request->file('img_sede');
                $archivoS = Storage::disk('web')->put('sed', $contentS);
                $c->img_sede = $archivoS;
            endif;

    		$c->nombre = e($request->input('nombre'));
    		$c->lugar = e($request->input('lugar'));
    		$c->direccion = e($request->input('direccion'));
    		$c->referencia = e($request->input('referencia'));
    		$c->ciudad = e($request->input('ciudad'));
    		$c->telef1 = e($request->input('telef1'));
    		$c->telef2 = e($request->input('telef2'));
    		$c->email = e($request->input('email'));
    		$c->ubicacion = e($request->input('ubicacion'));
    		$c->activo = e($request->input('activo'));
    		if($c->save()):
    			// if($request->hasFile('img_princ')):
    			// 	$f1 = $request->img_princ->storeAs($path, $filenameP, 'uploads');
    			// endif;
    			// if($request->hasFile('img_sede')):
    			// 	$f1 = $request->img_sede->storeAs($path, $filenameS, 'uploads');
    			// endif;
    			return redirect('/admin/web/sedes')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function postSedeGaleriaAdd($id, Request $request)
    {
    	$rules = [
    		'imagen' => 'required'
    	];
    	$messages = [
    		'imagen.required' => 'Ingrese nombre.'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		// $path = '/'.'sed/'.$id;
    		// $fileExt = trim($request->file('imagen')->getClientOriginalExtension());
    		// $upload_path = Config::get('filesystems.disks.uploads.root');
    		// $name = Str::slug(str_replace($fileExt, '', $request->file('imagen')->getClientOriginalName()));
    		// $filename = rand(1,999).$name.'.'.$fileExt;

            if($request->hasFile('imagen')){
                $content = $request->file('imagen');
                Storage::disk('web')->makeDirectory('sed/'.$id);
                $archivo = Storage::disk('web')->put('sed/'.$id, $content);
            }

    		$g = new Sedgaleria;
    		$g->sede_id = $id;
    		$g->imagen = $archivo;
    		if($g->save()):
    			// if($request->hasFile('imagen')):
    			// 	$f1 = $request->imagen->storeAs($path, $filename, 'uploads');
    			// endif;
    			return back()->with('message', 'Imagen agregada con exito')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getSedeGaleriaDel($id, $idgal)
    {
    	$g = Sedgaleria::findorFail($idgal);
        $imagen = $g->imagen;
    	if($g->sede_id != $id){
    		return back()->with('message', 'La imagen no se puede eliminar')->with('typealert', 'danger');
    	}else{
    		if($g->delete()):
	            Storage::disk('sed')->delete($imagen);
	            return back()->with('message', 'Imagen eliminada')->with('typealert', 'success');
			endif;

    	}
    }

    public function getSedeUp($id)
    {
        $ra = Sede::find($id);
        $orden = $ra->orden;
        if($orden - 1 <> 0):
            $id_no = Sede::where('orden',$orden-1)->value('id');
            $ra->orden = $orden - 1;
            if($ra->save()):
                $r = Sede::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }

    public function getSedeDown($id)
    {
        $ra = Sede::find($id);
        $orden = $ra->orden;
        $exi = Sede::where('orden',$orden+1)->exists();
        if($exi):
            $id_no = Sede::where('orden',$orden+1)->value('id');
            $ra->orden = $orden + 1;
            if($ra->save()):
                $r = Sede::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }
}
