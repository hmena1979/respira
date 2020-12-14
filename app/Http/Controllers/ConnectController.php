<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Hash, Auth;
use App\User;

use App\Http\Models\Param;

class ConnectController extends Controller
{
    public function __construct()
    {
		$this->middleware('guest')->except(['getLogout']);
	}

    public function getLogin()
    {
    	return view('connect.login');
    }

    public function getRegister()
    {
    	return view('connect.registerate');

    }
    
    public function postLogin(Request $request)
    {
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	];
    	$messages = [
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.'
		];
		

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
		else:
			//True: Siempre conectado - False: Se desconecta la session
			if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')],false)):
				$p = Param::count();
				if($p == 0){
					Param::insert([
						'ruc'=>'20530221548',
						'razsoc'=>'CENTRO NEUMOLOGICO DEL NORTE RESPIRA SAC',
						'padmision' => '122020',
						'pfarmacia' => '122020',
						'ubigeo' => '200101',
						'direccion' => 'PROCER MENDIBURO N° 203',
						'urbanizacion' => 'CLUB GRAU',
						'provincia' => 'PIURA',
						'departamento' => 'PIURA',
						'distrito' => 'PIURA',
						'pais' => 'PE',
						'por_igv' => 18,
						'por_renta' => 8,
						'monto_renta' => 1500,
						'sadmision' => '001',
						'sfarmacia' => '002'
						]);
				}
				$param = Param::FindOrFail(1);
				session(['fecha' => \Carbon\Carbon::now()->format('Y-m-d')]);
				session(['padmision' => $param->padmision]);
				session(['pfarmacia' => $param->pfarmacia]);
                session(['igv' => $param->por_igv]);
    			return redirect('/admin');
    		else:
    			return back()->with('message', 'Correo electrónico o clave incorrecto')->with('typealert', 'danger');
    		endif;
    	endif;

    }
    
    public function postRegister(Request $request)
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
    		'cpassword.same' => 'Confirmación de Contraseña distinto.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
    	else:
    		$user = new User;
    		$user->nombre = e($request->input('nombre'));
    		$user->apellido = e($request->input('apellido'));
    		$user->email = e($request->input('email'));
			$user->password = Hash::make($request->input('password'));
			$user->doctor_id = 1;

			$permissions = [
				'dashboard' => true,
				'usuarios' => true,
				'usuario_add' => true,
				'usuario_permissions' => true			
			];
			$permissions = json_encode($permissions);
			$user->permissions = $permissions;

			if($user->save()):
				$p = Param::count();
				if($p == 0){
					Param::insert([
						'ruc'=>'20530221548',
						'razsoc'=>'CENTRO NEUMOLOGICO DEL NORTE RESPIRA SAC',
						'padmision' => '122020',
						'pfarmacia' => '122020',
						'ubigeo' => '200101',
						'direccion' => 'PROCER MENDIBURO N° 203',
						'urbanizacion' => 'CLUB GRAU',
						'provincia' => 'PIURA',
						'departamento' => 'PIURA',
						'distrito' => 'PIURA',
						'pais' => 'PE',
						'por_igv' => 18,
						'por_renta' => 8,
						'monto_renta' => 1500,
						'sadmision' => '001',
						'sfarmacia' => '002'
						]);
				}
    			return redirect('/login')->with('message', 'Registro guardado')->with('typealert', 'success');

    		endif;


    	endif;

    }

    public function getLogout()
    {
    	Auth::logout();
    	return redirect('/');
    }
}
