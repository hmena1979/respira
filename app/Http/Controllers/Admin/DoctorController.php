<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Doctor;

class DoctorController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getDoctorHome($status)
    {
        switch ($status) {
            case '1':
                $doctores = Doctor::where('activo',1)->where('id','<>',1)->get();
                break;
            case '2':
                $doctores = Doctor::where('activo',2)->where('id','<>',1)->get();					
                break;
            case 'all':
                $doctores = Doctor::where('id','<>',1)->get();
                break;
        }
        
        $data = [
            'doctores' => $doctores
        ];
    	return view('admin.doctores.home', $data);
    }

    public function getDoctorAdd()
    {
        return view('admin.doctores.add');
    }

    public function postDoctorAdd(Request $request)
    {
    	$rules = [
    		'nombre' => 'required',
    		'especialidad' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'especialidad.required' => 'Ingrese especialidad.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$doctor = new Doctor;
    		$doctor->nombre = Str::upper(e($request->input('nombre')));
            $doctor->especialidad = Str::upper(e($request->input('especialidad')));
            $doctor->cmp = e($request->input('cmp'));
            $doctor->rne = e($request->input('rne'));
            $doctor->celular = e($request->input('celular'));
            $doctor->telefono = e($request->input('telefono'));
            $doctor->activo = $request->input('activo');

    		if($doctor->save()):
    			return redirect('/admin/doctores/1')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }
    
    public function getDoctorEdit($id)
	{
		$doctor = Doctor::findOrFail($id);
		$data = ['doctor' => $doctor];
        return view('admin.doctores.edit', $data);
    }
    
    public function postDoctorEdit(Request $request, $id)
    {
    	$rules = [
    		'nombre' => 'required',
    		'especialidad' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese nombre.',
    		'especialidad.required' => 'Ingrese especialidad.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$doctor = Doctor::findOrFail($id);
    		$doctor->nombre = Str::upper(e($request->input('nombre')));
            $doctor->especialidad = Str::upper(e($request->input('especialidad')));
            $doctor->cmp = e($request->input('cmp'));
            $doctor->rne = e($request->input('rne'));
            $doctor->celular = e($request->input('celular'));
            $doctor->telefono = e($request->input('telefono'));
            $doctor->activo = $request->input('activo');

    		if($doctor->save()):
    			return redirect('/admin/doctores/1')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
    }

    public function getDoctorDelete($id){
    	$c = Doctor::findOrFail($id);
    	if($c->delete()):
			return back()->with('message', 'Registro eliminado')->with('typealert', 'success');
		endif;
    }
}
