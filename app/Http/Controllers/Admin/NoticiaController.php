<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Config;
use Storage;

use App\Http\Models\Noticia;

class NoticiaController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getNoticiaHome()
    {
    	$not = Noticia::orderBy('orden')->get();
    	$data = [
            'not'=>$not
        ];
    	return view('admin.noticias.home', $data);
    }

    public function getNoticiaAdd()
    {    	
    	return view('admin.noticias.add');
    }

    public function postNoticiaAdd(Request $request)
    {
        $reg = Noticia::count();
    	$rules = [
    		'titulo' => 'required',
    		'fecha' => 'required',
    		'imagen' => 'required'
    	];
    	$messages = [
    		'titulo.required' => 'Ingrese título.',
    		'fecha.required' => 'Ingrese fecha',
    		'imagen.required' => 'Seleccione una imagen',
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		// $path = '/'.'not';
    		// $fileExt = trim($request->file('imagen')->getClientOriginalExtension());
    		// $upload_path = Config::get('filesystems.disks.uploads.root');
    		// $name = Str::slug(str_replace($fileExt, '', $request->file('imagen')->getClientOriginalName()));
    		// $filename = rand(1,999).$name.'.'.$fileExt;
            $content = $request->file('imagen');
            Storage::disk('web')->makeDirectory('not');
            $archivo = Storage::disk('web')->put('not', $content);

    		$c = new Noticia;
    		$c->titulo = e($request->input('titulo'));
    		$c->fecha = e($request->input('fecha'));
    		$c->imagen = $archivo;
    		$c->contenido = e($request->input('contenido'));
            $c->fuente = e($request->input('fuente'));
    		$c->activo = e($request->input('activo'));
            $c->orden = $reg + 1;
    		if($c->save()):
    			// if($request->hasFile('imagen')):
    			// 	$f1 = $request->imagen->storeAs($path, $filename, 'uploads');
    			// endif;
    			return redirect('/admin/web/noticias')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getNoticiaEdit($id)
    {
        $not = Noticia::find($id);
        $data = [
            'not'=>$not
        ];
        return view('admin.noticias.edit', $data);
    }

    public function postNoticiaEdit($id, Request $request)
    {
        $rules = [
            'titulo' => 'required',
            'fecha' => 'required',
        ];
        $messages = [
            'titulo.required' => 'Ingrese título.',
            'fecha.required' => 'Ingrese fecha',
        ];

        $validator = validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $path = '/'.'not';
            $c = Noticia::find($id);
            if($request->hasFile('imagen')){
                $ruta = $c->imagen;
                Storage::disk('web')->delete($ruta);

                $content = $request->file('imagen');
                $archivo = Storage::disk('web')->put('not', $content);
                
                $c->imagen = $archivo;
            }
            $c->titulo = e($request->input('titulo'));
            $c->fecha = e($request->input('fecha'));
            $c->contenido = e($request->input('contenido'));
            $c->fuente = e($request->input('fuente'));
            $c->activo = e($request->input('activo'));           
            if($c->save()):
                if($request->hasFile('imagen')):
                    $f1 = $request->imagen->storeAs($path, $filename, 'uploads');
                endif;
                return redirect('/admin/web/noticias')->with('message', 'Registro guardado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getNoticiaDel($id){
    	$c = Noticia::find($id);
        $imagen = $c->imagen;
    	if($c->delete()):
            Storage::disk('web')->delete($imagen );
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }

    public function getNoticiaUp($id)
    {
        $ra = Noticia::find($id);
        $orden = $ra->orden;
        if($orden - 1 <> 0):
            $id_no = Noticia::where('orden',$orden-1)->value('id');
            $ra->orden = $orden - 1;
            if($ra->save()):
                $r = Noticia::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }

    public function getNoticiaDown($id)
    {
        $ra = Noticia::find($id);
        $orden = $ra->orden;
        $exi = Noticia::where('orden',$orden+1)->exists();
        if($exi):
            $id_no = Noticia::where('orden',$orden+1)->value('id');
            $ra->orden = $orden + 1;
            if($ra->save()):
                $r = Noticia::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }
}
