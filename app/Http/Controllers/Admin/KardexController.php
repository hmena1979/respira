<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Kardex;
use App\Http\Models\Saldo;
use App\Http\Models\Producto;
// use App\Http\Models\Ingreso;
// use App\Http\Models\Detingreso;

class KardexController extends Controller
{
    public function __construct()
    {
      
    $this->middleware('auth');		
    $this->middleware('isadmin');
    $this->middleware('permissions');
    }

    public function Regenerate($periodo,$producto)
    {
        $kardexes = Kardex::where('periodo',$periodo)->where('producto_id',$producto)->orderBy('fecha')->get();
        $perant = pAnterior($periodo);
        $salant = Saldo::where('periodo',$perant)->where('producto_id',$producto)->get();
        $entradas = 0;
        $salidas = 0;
        if($salant->count() == 0){
            $salant = Saldo::where('periodo','000000')->where('producto_id',$producto)->get();
            if($salant->count() <> 0){
                $sti = $salant[0]->saldo;
                $stock = $salant[0]->saldo;
                $precio = $salant[0]->precio;
            }else{
                $sti = 0;
                $stock = 0.00;
                $precio = 0.00;
            }
        }

        foreach($kardexes as $kardex){
            switch ($kardex->tipo){
                case 1:
                    if($kardex->cant_ent+$stock == 0){
                        $sum = 1;
                    }else{
                        $sum = $kardex->cant_ent+$stock;
                    }
                    $precio = round((($kardex->cant_ent*$kardex->pre_compra)+($stock*$precio))/$sum,4);
                    $stock = $stock + $kardex->cant_ent;
                    $entradas += $kardex->cant_ent;
                    if($kardex->cant_sald <> $stock || $kardex->pre_prom <> $precio){
                        $k = Kardex::findOrFail($kardex->id);
                        $k->cant_sald = $stock;
                        $k->pre_prom = $precio;
                        $kg = $k->save();
                    }                    
                    break;
                case 2:
                    $stock = $stock - $kardex->cant_sal;
                    $salidas += $kardex->cant_sal;
                    if($kardex->cant_sald <> $stock || $kardex->pre_prom <> $precio){
                        $k = Kardex::findOrFail($kardex->id);
                        $k->cant_sald = $stock;
                        $k->pre_prom = $precio;
                        $kg = $k->save();
                    }                    
                break;
                case 3:
                    if($kardex->cant_ent+$stock == 0){
                        $sum = 1;
                    }else{
                        $sum = $kardex->cant_ent+$stock;
                    }
                    $precio = round((($kardex->cant_ent*$kardex->pre_compra)+($stock*$precio))/$sum,4);
                    $stock = $stock + $kardex->cant_ent;
                    $entradas += $kardex->cant_ent;
                    if($kardex->cant_sald <> $stock || $kardex->pre_prom <> $precio){
                        $k = Kardex::findOrFail($kardex->id);
                        $k->cant_sald = $stock;
                        $k->pre_prom = $precio;
                        $kg = $k->save();
                    }                    
                    break;
                // default:
                //     $titulo = 'Código';
                //     break;
            }
        }
        if($periodo == session('pfarmacia')){
            //Actualiza producto
            $p = Producto::findOrFail($producto);
            $p->stock = $stock;
            $p->precompra = $precio;
            $pg = $p->save();
            //Actualiza Saldo, si se ha cerrado el mes
            $saldo = Saldo::where('periodo',$periodo)->where('producto_id',$producto)->update([
                'inicial' => $sti,
                'entradas' => $entradas,
                'salidas' => $salidas,
                'saldo' => $stock,
                'precio' => $precio
            ]);
        }else{
            $saldo = Saldo::where('periodo',$periodo)->where('producto_id',$producto)->update([
                'inicial' => $sti,
                'entradas' => $entradas,
                'salidas' => $salidas,
                'saldo' => $stock,
                'precio' => $precio
            ]);
        }
        return true;

    }
}
