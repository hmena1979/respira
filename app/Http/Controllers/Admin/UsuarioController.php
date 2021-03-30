<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Hash, Auth, Str;

use App\User;
use App\Http\Models\Doctor;

class UsuarioController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getUsuarioHome($status)
    {
		if(kvfj(Auth::user()->permissions,'usuario_permissions')):
			switch ($status) {
				case '1':
					$users = User::where('activo',1)->get();
					break;
				case '2':
					$users = User::where('activo',2)->get();					
					break;
				case 'all':
					$users = User::get();
					break;
			}
		else:
			$users = User::where('id',Auth::user()->id)->get();
		endif;
        
        $data = [
            'users'=>$users
        ];
        return view('admin.usuarios.home', $data);
    }

    public function getUsuarioAdd()
    {
		$doctores = Doctor::where('activo', 1)->pluck('nombre','id');
		$data = [
            'doctores'=>$doctores
        ];
        return view('admin.usuarios.add', $data);
    }

    public function postUsuarioAdd(Request $request)
    {
    	$rules = [
    		'nombre' => 'required',
    		'apellido' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:8',
    		'cpassword' => 'required|same:password'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'apellido.required' => 'Ingrese Apellido.',
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$user = new User;
    		$user->nombre = Str::upper(e($request->input('nombre')));
    		$user->apellido = Str::upper(e($request->input('apellido')));
    		$user->email = e($request->input('email'));
			$user->password = Hash::make($request->input('password'));
			$user->activo = $request->input('activo');
			$user->doctor_id = $request->input('doctor_id');

    		if($user->save()):
    			return redirect('/admin/usuarios/all')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
	}

	public function getUsuarioEdit($id)
	{
		$user = User::findOrFail($id);
		$doctores = Doctor::where('activo', 1)->pluck('nombre','id');
		$data = [
			'user' => $user,
			'doctores' => $doctores
		];
        return view('admin.usuarios.edit', $data);
	}

	public function postUsuarioEdit(Request $request, $id)
	{
		$rules = [
    		'nombre' => 'required',
    		'apellido' => 'required',
    		'email' => 'required'
    	];
    	$messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'apellido.required' => 'Ingrese Apellido.',
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$user = User::findOrFail($id);
    		$user->nombre = Str::upper(e($request->input('nombre')));
    		$user->apellido = Str::upper(e($request->input('apellido')));
			$user->email = e($request->input('email'));
			$user->activo = $request->input('activo');
			$user->doctor_id = $request->input('doctor_id');
    		if($user->save()):
    			return redirect('/admin/usuarios/all')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;
    	endif;
	}

	public function getUsuarioPassword($id)
	{
		$user = User::findOrFail($id);
		$data = ['user' => $user];
        return view('admin.usuarios.password', $data);
	}

	public function postUsuarioPassword(Request $request, $id)
    {
    	$rules = [
    		'password' => 'required|min:8',
    		'cpassword' => 'required|same:password'
    	];
    	$messages = [
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$user = User::findOrFail($id);
    		$user->password = Hash::make($request->input('password'));

    		if($user->save()):
    			return redirect('/admin/usuarios/all')->with('message', 'Contraseña cambiada con exito')->with('typealert', 'success');

    		endif;
    	endif;
	}
	
	public function getUsuarioPermissions($id)
	{
		$user = User::findOrFail($id);
		$data = ['user' => $user];
        return view('admin.usuarios.permissions', $data);
	}

	public function postUsuarioPermissions(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$permissions = [
			'pdf' => true,
			'dashboard' => $request->input('dashboard'),
			'parametros' => $request->input('parametros'),
			'import' => $request->input('import'),
			'report' => $request->input('report'),
			'sunat' => $request->input('sunat'),
			'saldos' => $request->input('saldos'),
			'cierre' => $request->input('cierre'),
			'vencimientos' => $request->input('vencimientos'),
			'web' => $request->input('web'),
			'cadmision' => $request->input('cadmision'),
			'cfarmacia' => $request->input('cfarmacia'),
			'usuarios' => $request->input('usuarios'),
			'usuario_add' => $request->input('usuario_add'),
			'usuario_edit' => $request->input('usuario_edit'),
			'usuario_password' => $request->input('usuario_password'),
			'usuario_permissions' => $request->input('usuario_permissions'),
			'categorias' => $request->input('categorias'),
			'categoria_add' => $request->input('categoria_add'),
			'categoria_edit' => $request->input('categoria_edit'),
			'categoria_delete' => $request->input('categoria_delete'),
			'pacientes' => $request->input('pacientes'),
			'paciente_add' => $request->input('paciente_add'),
			'paciente_edit' => $request->input('paciente_edit'),
			'paciente_history' => $request->input('paciente_history'),
			'paciente_triage' => $request->input('paciente_triage'),
			'paciente_delete' => $request->input('paciente_delete'),
			'paciente_appointment' => $request->input('paciente_appointment'),
			'doctores' => $request->input('doctores'),
			'doctor_add' => $request->input('doctor_add'),
			'doctor_edit' => $request->input('doctor_edit'),
			'doctor_delete' => $request->input('doctor_delete'),
			'cie10' => $request->input('cie10'),
			'cie10_add' => $request->input('cie10_add'),
			'cie10_edit' => $request->input('cie10_edit'),
			'cie10_delete' => $request->input('cie10_delete'),
			'umedidas' => $request->input('umedidas'),
			'umedida_add' => $request->input('umedida_add'),
			'umedida_edit' => $request->input('umedida_edit'),
			'umedida_delete' => $request->input('umedida_delete'),
			'productos' => $request->input('productos'),
			'producto_add' => $request->input('producto_add'),
			'producto_edit' => $request->input('producto_edit'),
			'producto_price' => $request->input('producto_price'),
			'producto_delete' => $request->input('producto_delete'),
			'tipmeds' => $request->input('tipmeds'),
			'tipmed_add' => $request->input('tipmed_add'),
			'tipmed_edit' => $request->input('tipmed_edit'),
			'tipmed_delete' => $request->input('tipmed_delete'),
			'historias' => $request->input('historias'),
			'historia_triage' => $request->input('historia_triage'),
			'historia_add' => $request->input('historia_add'),
			'historia_edit' => $request->input('historia_edit'),
			'historia_plan' => $request->input('historia_plan'),
			'historia_diagnosis' => $request->input('historia_diagnosis'),
			'historia_cita' => $request->input('historia_cita'),
			'historia_prescription' => $request->input('historia_prescription'),
			'servicios' => $request->input('servicios'),
			'servicio_add' => $request->input('servicio_add'),
			'servicio_edit' => $request->input('servicio_edit'),
			'servicio_delete' => $request->input('servicio_delete'),
			'proveedores' => $request->input('proveedores'),
			'proveedor_add' => $request->input('proveedor_add'),
			'proveedor_edit' => $request->input('proveedor_edit'),
			'proveedor_delete' => $request->input('proveedor_delete'),
			'comprobantes' => $request->input('comprobantes'),
			'comprobante_add' => $request->input('comprobante_add'),
			'comprobante_edit' => $request->input('comprobante_edit'),
			'comprobante_delete' => $request->input('comprobante_delete'),
			'facturas' => $request->input('facturas'),
			'factura_add' => $request->input('factura_add'),
			'factura_edit' => $request->input('factura_edit'),
			'factura_delete' => $request->input('factura_delete'),
			'ingresos' => $request->input('ingresos'),
			'ingreso_add' => $request->input('ingreso_add'),
			'ingreso_edit' => $request->input('ingreso_edit'),
			'ingreso_delete' => $request->input('ingreso_delete'),
			'salidas' => $request->input('salidas'),
			'salida_add' => $request->input('salida_add'),
			'salida_edit' => $request->input('salida_edit'),
			'salida_delete' => $request->input('salida_delete'),
			'notadms' => $request->input('notadms'),
			'notadm_add' => $request->input('notadm_add'),
			'notadm_edit' => $request->input('notadm_edit'),
			'notadm_delete' => $request->input('notadm_delete'),
			'notfars' => $request->input('notfars'),
			'notfar_add' => $request->input('notfar_add'),
			'notfar_edit' => $request->input('notfar_edit'),
			'notfar_delete' => $request->input('notfar_delete'),
			'modrecetas' => $request->input('modrecetas'),
			'modreceta_add' => $request->input('modreceta_add'),
			'modreceta_edit' => $request->input('modreceta_edit'),
			'modreceta_delete' => $request->input('modreceta_delete'),
			'terapias' => $request->input('terapias'),
			'terapia_add' => $request->input('terapia_add'),
			'terapia_edit' => $request->input('terapia_edit'),
			'terapia_delete' => $request->input('terapia_delete'),
			'laboratorios' => $request->input('laboratorios'),
			'laboratorio_add' => $request->input('laboratorio_add'),
			'laboratorio_edit' => $request->input('laboratorio_edit'),
			'laboratorio_delete' => $request->input('laboratorio_delete')
		];
		$permissions = json_encode($permissions);
		$user->permissions = $permissions;
		if($user->save()):
			return redirect('/admin/usuarios/all')->with('message', 'Permisos agregados con éxito')->with('typealert', 'success');
		endif;
	}
}
