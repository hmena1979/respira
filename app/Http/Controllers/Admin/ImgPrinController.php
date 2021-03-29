<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Config;
use Storage;

use App\Http\Models\Imgprin;

class ImgPrinController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getHome()
    {
    	$im = Imgprin::orderBy('orden')->get();
    	$data = [
            'im'=>$im
        ];
    	return view('admin.imgprin.home', $data);
    }

    public function getAdd()
    {
    	return view('admin.imgprin.add');
    }

    public function postAdd(Request $request)
    {
        $reg = Imgprin::count();
    	$rules = [
    		'imagen' => 'required'
    	];
    	$messages = [
    		'imagen.required' => 'Seleccione una imagen',
    		'imagen.image' => 'El archivo seleccionado no es una imagen'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		// $fileExt = trim($request->file('imagen')->getClientOriginalExtension());
    		// $name = Str::slug(str_replace($fileExt, '', $request->file('imagen')->getClientOriginalName()));
    		// $archivo = rand(1,999).$name.'.'.$fileExt;
            // $archivo = $id.'/'.$archivo;
            $content = $request->file('imagen');
            Storage::disk('web')->makeDirectory('ip');
            $archivo = Storage::disk('web')->put('ip', $content);

    		$c = new Imgprin;
    		$c->imagen = $archivo;
    		$c->activo = e($request->input('activo'));
            $c->orden = $reg + 1;
    		if($c->save()):
    			// if($request->hasFile('imagen')):
    			// 	$f1 = $request->imagen->storeAs($path, $filename, 'uploads');
    			// endif;
    			return redirect('/admin/web/imgprins')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getEdit($id)
    {
    	$im = Imgprin::find($id);
    	$data = [
            'im'=>$im
        ];
    	return view('admin.imgprin.edit', $data);
    }

    public function postEdit($id, Request $request)
    {
    	$rules = [
    		'imagen' => 'required'
    	];
    	$messages = [
    		'imagen.required' => 'Seleccione una imagen',
    		'imagen.image' => 'El archivo seleccionado no es una imagen'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$path = '/'.'ip';
            $c = Imgprin::find($id);
            if($request->hasFile('imagen')){
                $ruta = $c->imagen;
                Storage::disk('web')->delete($ruta);

                $content = $request->file('imagen');
                $archivo = Storage::disk('web')->put('ip', $content);
                
                $c->imagen = $archivo;
            }
            
            $c->activo = e($request->input('activo')); 
    		if($c->save()):
    			// if($request->hasFile('imagen')):
    			// 	$f1 = $request->imagen->storeAs($path, $filename, 'uploads');
    			// endif;
    			return redirect('/admin/web/imgprins')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getDel($id)
    {
    	$c = Imgprin::find($id);
        $upload_path = Config::get('filesystems.disks.uploads.root');
        $path = '/'.'ip';
        $imagen = $c->imagen;
    	if($c->delete()):
            unlink($upload_path.$path.'/'.$imagen);
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }

    public function getUp($id)
    {
        $ra = Imgprin::find($id);
        $orden = $ra->orden;
        if($orden - 1 <> 0):
            $id_no = Imgprin::where('orden',$orden-1)->value('id');
            $ra->orden = $orden - 1;
            if($ra->save()):
                $r = Imgprin::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }

    public function getDown($id)
    {
        $ra = Imgprin::find($id);
        $orden = $ra->orden;
        $exi = Imgprin::where('orden',$orden+1)->exists();
        if($exi):
            $id_no = Imgprin::where('orden',$orden+1)->value('id');
            $ra->orden = $orden + 1;
            if($ra->save()):
                $r = Imgprin::where('id',$id_no)->update(['orden'=>$orden]);
                return back();
            endif;
        else:
            return back();
        endif;
    }
}
