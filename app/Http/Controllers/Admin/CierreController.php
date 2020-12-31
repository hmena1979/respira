<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\KardexController;
use Illuminate\Http\Request;
use Validator, Hash, Auth, Str;

use App\Http\Models\Kardex;
use App\Http\Models\Param;
use App\Http\Models\Producto;
use App\Http\Models\Saldo;

class CierreController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getCierreHome()
    {
        return view('admin.cierres.home');
    }

    public function postCierreAdmision(Request $request)
    {
        $rules = [
            'padmision' => 'required'
    	];
    	$messages = [
    		'padmision.required' => 'Ingrese periodo.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $periodo = e($request->input('padmision'));
            $nperiodo = pSiguiente($periodo);
            $parametro = Param::findOrFail(1);
            $parametro->padmision = $nperiodo;
            session(['padmision' => $nperiodo]);
            if($parametro->save()){
                return redirect('/admin')->with('message', 'Periodo cerrado')->with('typealert', 'success');
            }
        endif;
    }

    public function postCierreFarmacia(Request $request)
    {
        $rules = [
            'pfarmacia' => 'required'
    	];
    	$messages = [
    		'pfarmacia.required' => 'Ingrese periodo.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        else:
            $periodo = e($request->input('pfarmacia'));
            $perant = pAnterior($periodo);
            //-------------------Regenera Stock------------------------------------------------
            $productos = Producto::select('id')->get();
            $kardex = new KardexController();
            foreach($productos as $producto){
                $b = $kardex->Regenerate($periodo,$producto->id);
            }
            //---------------------------------------------------------------------------------
            //-------------------Genera saldos------------------------------------------------
            $sant = Saldo::where('periodo', $periodo )->delete();
            $productos = Producto::select('id','stock','precompra')->get();
            foreach($productos as $producto){
                $entradas = Kardex::where('periodo', $periodo)->where('producto_id',$producto->id)->sum('cant_ent');
                $salidas = Kardex::where('periodo', $periodo)->where('producto_id',$producto->id)->sum('cant_sal');
                $salant = Saldo::where('periodo',$perant)->where('producto_id',$producto)->get();
                if($salant->count() == 0){
                    $salant = Saldo::where('periodo','000000')->where('producto_id',$producto)->get();
                    if($salant->count() <> 0){
                        $inicial = $salant[0]->saldo;
                    }else{
                        $inicial = 0.00;
                    }
                }else{
                    $inicial = $salant[0]->saldo;
                }
                Saldo::insert([
                    'periodo'=>$periodo,
                    'producto_id'=>$producto->id,
                    'inicial'=>$inicial,
                    'entradas'=>$entradas,
                    'salidas'=>$salidas,
                    'saldo'=>$producto->stock,
                    'precio'=>$producto->precompra
                    ]);
            }
            //---------------------------------------------------------------------------------
            $nperiodo = pSiguiente($periodo);
            $parametro = Param::findOrFail(1);
            $parametro->pfarmacia = $nperiodo;
            session(['pfarmacia' => $nperiodo]);
            if($parametro->save()){
                return redirect('/admin')->with('message', 'Periodo cerrado')->with('typealert', 'success');
            }
        endif;
    }
}
