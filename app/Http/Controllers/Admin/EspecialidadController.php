<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Config;
use Storage;

use App\Http\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getEspecialidadHome()
    {
    	$esp = Especialidad::orderBy('orden')->get();
    	$data = [
            'esp'=>$esp
        ];
    	return view('admin.especialidads.home', $data);
    }

    public function getEspecialidadAdd()
    {
    	$esp = Especialidad::get();
    	$data = [
            'esp'=>$esp
        ];
    	return view('admin.especialidads.add', $data);
    }

    public function postEspecialidadAdd(Request $request)
    {
        $reg = Especialidad::count();
    	$rules = [
    		'nombre' => 'required',
    		'nom_corto' => 'required',
    		'imagen' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'nom_corto.required' => 'Ingrese nombre corto',
    		'imagen.required' => 'Seleccione una imagen',
    		'imagen.image' => 'El archivo seleccionado no es una imagen'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		// $path = '/'.'esp';
    		// $fileExt = trim($request->file('imagen')->getClientOriginalExtension());
    		// $upload_path = Config::get('filesystems.disks.uploads.root');
    		// $name = Str::slug(str_replace($fileExt, '', $request->file('imagen')->getClientOriginalName()));
    		// $filename = rand(1,999).$name.'.'.$fileExt;
            $content = $request->file('imagen');
            Storage::disk('web')->makeDirectory('esp');
            $archivo = Storage::disk('web')->put('esp', $content);

    		$c = new Especialidad;
    		//$filename = 'esp'.$c->id.'.'.$fileExt;
    		$c->nombre = e($request->input('nombre'));
    		$c->nom_corto = e($request->input('nom_corto'));
    		$c->nom_corto = e($request->input('nom_corto'));
    		$c->icono = e($request->input('icono'));
    		$c->imagen = $archivo;
    		$c->contenido = e($request->input('contenido'));
    		$c->activo = e($request->input('activo'));
            $c->orden = $reg + 1;
    		if($c->save()):
    			// if($request->hasFile('imagen')):
    			// 	$f1 = $request->imagen->storeAs($path, $filename, 'uploads');
    			// endif;
    			return redirect('/admin/web/especialidads')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getEspecialidadEdit($id)
    {
        $esp = Especialidad::find($id);
        $data = [
            'esp'=>$esp
        ];
        return view('admin.especialidads.edit', $data);
    }

    public function postEspecialidadEdit($id, Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'nom_corto' => 'required',
        ];
        $messages = [
            'nombre.required' => 'Ingrese nombre.',
            'nom_corto.required' => 'Ingrese nombre corto',
        ];

        $validator = validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $path = '/'.'esp';
            $c = Especialidad::find($id);
            if($request->hasFile('imagen')){
                $ruta = $c->imagen;
                Storage::disk('web')->delete($ruta);

                $content = $request->file('imagen');
                $archivo = Storage::disk('web')->put('esp', $content);
                $c->imagen = $archivo;
            }
            
            $c->nombre = e($request->input('nombre'));
            $c->nom_corto = e($request->input('nom_corto'));
            $c->icono = e($request->input('icono'));
            $c->contenido = e($request->input('contenido'));
            $c->activo = e($request->input('activo'));           
            if($c->save()):
                // if($request->hasFile('imagen')):
                //     $f1 = $request->imagen->storeAs($path, $filename, 'uploads');
                // endif;
                return redirect('/admin/web/especialidads')->with('message', 'Registro guardado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getEspecialidadDel($id)
    {
    	$c = Especialidad::find($id);
        $imagen = $c->imagen;
    	if($c->delete()):
            Storage::disk('esp')->delete($imagen);
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }

    public function getEspecialidadUp($id)
    {
        $ra = Especialidad::find($id);
        $orden = $ra->orden;
        if($orden - 1 <> 0):
            $id_no = Especialidad::where('orden',$orden-1)->value('id');
            $ra->orden = $orden - 1;
            if($ra->save()):
                $r = Especialidad::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }

    public function getEspecialidadDown($id)
    {
        $ra = Especialidad::find($id);
        $orden = $ra->orden;
        $exi = Especialidad::where('orden',$orden+1)->exists();
        if($exi):
            $id_no = Especialidad::where('orden',$orden+1)->value('id');
            $ra->orden = $orden + 1;
            if($ra->save()):
                $r = Especialidad::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }
}
