<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\KardexController;
use Illuminate\Http\Request;
use Validator, Str;

use App\Http\Models\Param;
use App\Http\Models\Correlativo;
use App\Http\Models\Producto;

class ParamController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getParametroHome()
    {
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
        $c = Correlativo::count();
        if($c == 0){
            Correlativo::insert([
                'index'=>'HISTORIA',
                'descripcion'=>'Historia clínica',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'B001',
                'descripcion'=>'Boleta admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'F001',
                'descripcion'=>'Factura admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'FD01',
                'descripcion'=>'ND Factura admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'FC01',
                'descripcion'=>'NC Factura admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'BD01',
                'descripcion'=>'ND Boleta admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'BC01',
                'descripcion'=>'NC Boleta admisión',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'B002',
                'descripcion'=>'Boleta farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'F002',
                'descripcion'=>'Factura farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'FD02',
                'descripcion'=>'ND Factura farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'FC02',
                'descripcion'=>'NC Factura farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'BD02',
                'descripcion'=>'ND Boleta farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'BC02',
                'descripcion'=>'NC Boleta farmacia',
                'valor'=>0
                ]);
            Correlativo::insert([
                'index'=>'C002',
                'descripcion'=>'Consumo farmacia',
                'valor'=>0
                ]);
        }

        $param = Param::findOrFail(1);
        $data = [
            'param' => $param
        ];
        return view('admin.parametros.home', $data);
    }

    public function postParametroHome(Request $request)
    {
        $rules = [
    		'ubigeo' => 'required',
            'direccion' => 'required',
            'urbanizacion' => 'required',
            'provincia' => 'required',
            'departamento' => 'required',
            'distrito' => 'required',
            'pais' => 'required',
            'por_igv' => 'required',
            'por_renta' => 'required',
            'sadmision' => 'required',
            'sfarmacia' => 'required'
    	];
    	$messages = [
    		'ubigeo.required' => 'Ingrese código IBIGEO.',
    		'direccion.required' => 'Ingrese dirección.',
            'urbanizacion.required' => 'Ingrese urbanización.',
            'provincia.required' => 'Ingrese provincia.',
            'departamento.required' => 'Ingrese departamento.',
            'distrito.required' => 'Ingrese distrito.',
            'pais.required' => 'Ingrese pais.',
            'por_igv.required' => 'Ingrese porcentaje IGV.',
            'por_renta.required' => 'Ingrese porcentaje Renta.',
            'sadmision.required' => 'Ingrese serie Admisión.',
            'sfarmacia.required' => 'Ingrese serie Renta.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $p = Param::findOrFail(1);
            $p->ubigeo = Str::upper(e($request->input('ubigeo')));
            $p->direccion = Str::upper(e($request->input('direccion')));
            $p->urbanizacion = Str::upper(e($request->input('urbanizacion')));
            $p->provincia = Str::upper(e($request->input('provincia')));
            $p->departamento = Str::upper(e($request->input('departamento')));
            $p->distrito = Str::upper(e($request->input('distrito')));
            $p->pais = Str::upper(e($request->input('pais')));
            $p->por_igv = e($request->input('por_igv'));
            $p->por_renta = e($request->input('por_renta'));
            $p->sadmision = e($request->input('sadmision'));
            $p->sfarmacia = e($request->input('sfarmacia'));
            $p->usuario = Str::upper(e($request->input('usuario')));
            $p->clave = e($request->input('clave'));
            $p->apitoken = $request->input('apitoken');
            $p->servidor = e($request->input('servidor'));
            $p->dominio = e($request->input('dominio'));
            $p->cuenta = e($request->input('cuenta'));

            if($p->save()):
    			return redirect('/admin')->with('message', 'Registro guardado')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getParametroSaldos()
    {
        $productos = Producto::orderBy('nombre','asc')->pluck('nombre','id');
        $data = [
            'productos' => $productos
        ];
        return view('admin.parametros.saldos', $data);
    }

    public function postParametroSaldos(Request $request)
    {
        if(e($request->input('tipo')) == 1){
            $periodo = e($request->input('periodo'));
            $productos = Producto::get();
            $kardex = new KardexController();
            foreach($productos as $producto){
                $b = $kardex->Regenerate($periodo,$producto->id);
            }
        }else{
            $tipo = e($request->input('tipo'));
            $producto = e($request->input('producto'));
            $periodo = e($request->input('periodo'));
            $kardex = new KardexController();
            $b = $kardex->Regenerate($periodo,$producto);
        }
        return redirect('/admin/saldos')->with('message', 'Saldo regenerado')->with('typealert', 'success');
    }
}
