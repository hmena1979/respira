<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Categoria;

class CategoriaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getCategoriaHome($module)
    {
        $cats = Categoria::where('modulo', $module)->orderBy('nombre','Asc')->get();
        //(0)Tipo documento / (1)Tipo paciente / (2)Sexo / (3)Estado civil
        switch ($module){
            case '0':
                $titulo = 'Código Sunat';
                break;
            case '10':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
        
        $data = [
            'cats' => $cats,
            'module'=>$module,
            'titulo'=>$titulo
        ];
    	return view('admin.categorias.home', $data);
    }

    public function getCategoriaAdd($module)
    {
        switch ($module){
            case '0':
                $titulo = 'Código Sunat';
                break;
            case '10':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
        $data = [
            'module'=>$module,
            'titulo'=>$titulo
        ];
        return view('admin.categorias.add', $data);
    }

    public function postCategoriaAdd(Request $request, $module)
    {
        //if($module === '0' || $module === '4' || $module === '5' || $module === '6'):
        $rules = [
            'nombre' => 'required',
            'codigo' => 'required'
        ];
        $messages = [
            'codigo.required' => 'Ingrese código.',
            'nombre.required' => 'Ingrese nombre.'
        ];
        $validator = validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $c = new Categoria;
            $c->modulo = $module;
            $c->codigo = Str::upper(e($request->input('codigo')));
            $c->nombre = Str::upper(e($request->input('nombre')));
            if($c->save()):
                return redirect('/admin/categorias/'.$module)->with('message', 'Registro guardado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getCategoriaEdit($id)
    {
        $cat = Categoria::findOrFail($id);
        switch ($cat->modulo){
            case '0':
                $titulo = 'Código Sunat';
                break;
            case '10':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
    	$data = [
            'cat'=>$cat,
            'titulo'=>$titulo
        ];
    	return view('admin.categorias.edit', $data);
    }

    public function postCategoriaEdit(Request $request, $id)
    {
        $c = Categoria::findOrFail($id);
        //if($c->modulo === 0 || $c->modulo  === 4 || $c->modulo  === 5 || $c->modulo  === 6):
        //if(strpos('0_4_5_6_7_8_9_10_11', $module)):
        $rules = [
            'nombre' => 'required',
            'codigo' => 'required'
        ];
        $messages = [
            'codigo.required' => 'Ingrese código.',
            'nombre.required' => 'Ingrese nombre.'
        ];
        $validator = validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $c->codigo = Str::upper(e($request->input('codigo')));
            $c->nombre = Str::upper(e($request->input('nombre')));
            if($c->save()):
                return redirect('/admin/categorias/'.$c->modulo)->with('message', 'Registro guardado')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getCategoriaDelete($id){
    	$c = Categoria::findOrFail($id);
    	if($c->delete()):
			return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }

    
}
