<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Paciente;
use App\Http\Models\Categoria;
use App\Http\Models\Param;

class ProveedorController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getProveedorHome()
    {
    	return view('admin.proveedores.home');
    }

    public function getProveedorRegistro()
    {
        //$prov = Paciente::select('id','numdoc','razsoc','telefono','email','tipo')->get();
        return datatables()
            ->of(Paciente::select('id','numdoc','razsoc','telefono','email','tipo'))
            ->addColumn('btn','admin.proveedores.action')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function getProveedorAdd()
    {
        $tipdoc = Categoria::where('modulo', 0)->orderBy('codigo')->pluck('nombre','codigo');
        $data = [
            'tipdoc' => $tipdoc
        ];
        return view('admin.proveedores.add', $data);
    }

    public function postProveedorAdd(Request $request)
    {
        if($request->input('tipdoc_id') == '6' && substr($request->input('numdoc'),0,2) == '20'){
            $rules = [
                'tipdoc_id' => 'required',
                'numdoc' => 'required',
                'razsoc' => 'required'
            ];

        }else{
            $rules = [
                'tipdoc_id' => 'required',
                'numdoc' => 'required',
                'ape_pat' => 'required',
                'nombre1' => 'required',
                'razsoc' => 'required'
            ];
        }
        
    	$messages = [
            'tipdoc_id.required' => 'Seleccione tipo de documento.',
    		'numdoc.required' => 'Ingrese número documento.',
            'ape_pat.required' => 'Ingrese apellido.',
            'nombre1.required' => 'Ingrese nombre.',
            'razsoc.required' => 'Ingrese razón social.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $paciente = new Paciente;
            $paciente->tipdoc_id = $request->input('tipdoc_id');
            $paciente->tipo = 2;
            $paciente->numdoc = e($request->input('numdoc'));
            $paciente->ape_pat = Str::upper(e($request->input('ape_pat')));
            $paciente->ape_mat = Str::upper(e($request->input('ape_mat')));
            $paciente->nombre1 = Str::upper(e($request->input('nombre1')));
            $paciente->nombre2 = Str::upper(e($request->input('nombre2')));
            $paciente->razsoc = Str::upper(e($request->input('razsoc')));
            $paciente->direccion = Str::upper(e($request->input('direccion')));
            $paciente->email = e($request->input('email'));
            $paciente->telefono = e($request->input('telefono'));

            if($paciente->save()):
    			return redirect('/admin/pacientes')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getProveedorEdit($id)
    {
        $proveedor = Paciente::findOrFail($id);
        $tipdoc = Categoria::where('modulo', 0)->orderBy('codigo')->pluck('nombre','codigo');
        $data = [
            'proveedor' => $proveedor,
            'tipdoc' => $tipdoc
        ];
        return view('admin.proveedores.edit', $data);
    }

    public function postProveedorEdit(Request $request, $id)
    {
        if($request->input('tipdoc_id') == '6' && substr($request->input('numdoc'),0,2) == '20'){
            $rules = [
                'tipdoc_id' => 'required',
                'numdoc' => 'required',
                'razsoc' => 'required'
            ];

        }else{
            $rules = [
                'tipdoc_id' => 'required',
                'numdoc' => 'required',
                'ape_pat' => 'required',
                'nombre1' => 'required',
                'razsoc' => 'required'
            ];
        }
        
    	$messages = [
            'tipdoc_id.required' => 'Seleccione tipo de documento.',
    		'numdoc.required' => 'Ingrese número documento.',
            'ape_pat.required' => 'Ingrese apellido.',
            'nombre1.required' => 'Ingrese nombre.',
            'razsoc.required' => 'Ingrese razón social.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $paciente = Paciente::findOrFail($id);
            $paciente->tipdoc_id = $request->input('tipdoc_id');
            $paciente->tipo = 2;
            $paciente->numdoc = e($request->input('numdoc'));
            $paciente->ape_pat = Str::upper(e($request->input('ape_pat')));
            $paciente->ape_mat = Str::upper(e($request->input('ape_mat')));
            $paciente->nombre1 = Str::upper(e($request->input('nombre1')));
            $paciente->nombre2 = Str::upper(e($request->input('nombre2')));
            $paciente->razsoc = Str::upper(e($request->input('razsoc')));
            $paciente->direccion = Str::upper(e($request->input('direccion')));
            $paciente->email = e($request->input('email'));
            $paciente->telefono = e($request->input('telefono'));

            if($paciente->save()):
    			return redirect('/admin/pacientes')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getProveedorDelete($id)
    {
        $s = Paciente::findOrFail($id);
        if($s->delete()):
            return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
        endif;
    }

    public function getBusProvNumdoc(Request $request, $codigo)
    {
    	if($request->ajax()){
            $pac = Paciente::where('numdoc', $codigo)->get();
            $parametro = Param::findOrFail(1);
            $token = $parametro->apitoken;
            //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InZlbnRhc0BkZXBpdXJhLm5ldCJ9.WQKC_wF_EfyJKCvDzIDN68DLIU-Spdu4q7_PSX7tHKs';
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
            ));
            

            if($pac[0]->tipdoc_id=='1'){
                $api = file_get_contents('https://dniruc.apisperu.com/api/v1/dni/'.$codigo.'?token='.$token,false,$context);
            }elseif($pac[0]->tipdoc_id=='6'){
                $api = file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/'.$codigo.'?token='.$token,false,$context);
            }else{
                $api = '';
            }

            //return $pac[0]->tipdoc_id;

            if($api == false){
                $respuesta = [
                    'estado' => '0',
                    'id' => $pac[0]->id
                ];
                return $respuesta;
            }

            if($pac[0]->tipdoc_id=='1'){
                $api = str_replace('&Ntilde;','Ñ',$api);
                $api = json_decode($api);
                $respuesta = [
                    'estado' => '1',
                    'id' => $pac[0]->id,
                    'ruc' => $api->dni,
                    'razsoc' => $api->apellidoPaterno.' '.$api->apellidoMaterno.' '.$api->nombres,
                    'direccion' => $pac[0]->direccion,
                    'doctor_id' => $pac[0]->doctor_id
                ];
            }elseif($pac[0]->tipdoc_id=='6'){
                $api = str_replace('&Ntilde;','Ñ',$api);
                $api = json_decode($api);
                $respuesta = [
                    'estado' => '1',
                    'id' => $pac[0]->id,
                    'ruc' => $api->ruc,
                    'razsoc' => $api->razonSocial,
                    'direccion' => $api->direccion.' '.$api->distrito.' '.$api->provincia.' '.$api->departamento,
                    'doctor_id' => $pac[0]->doctor_id
                ];
            }else{
                $api = '';
                $respuesta = [
                    'estado' => '1',
                    'id' => $pac[0]->id,
                    'ruc' => $pac[0]->numdoc,
                    'razsoc' => $pac[0]->razsoc,
                    'direccion' => $pac[0]->direccion,
                    'doctor_id' => $pac[0]->doctor_id
                ];
            }
            //$api = json_decode($api);
            //return response()->json($api);
            return $respuesta;            
    	}
    }

    public function getBusProvRazsoc(Request $request, $bus)
    {
        if($request->ajax()){            
            $cli = Paciente::where('razsoc','like','%'.$bus.'%')
                ->orderby('razsoc','Asc')
                ->take(10)
                ->get();
            return response()->json($cli);
        }
    }


}
