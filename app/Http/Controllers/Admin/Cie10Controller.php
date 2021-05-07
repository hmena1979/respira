<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator, Str;

use App\Http\Models\Cie10;

class Cie10Controller extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getCie10Home()
    {
        $cie10s = Cie10::query();        
        $data = [
            'cie10s' => $cie10s
        ];
        
        return view('admin.cie10s.home', $data);
    }

    public function getCie10Registro()
    {
        return datatables()
            ->eloquent(Cie10::query())
            ->addColumn('btn','admin.cie10s.action')
            ->rawColumns(['btn'])
            ->toJson();
        //return DataTables::of(Cie10::query())->make(true);
        //return datatables(Cie10::all())->toJson();
    }

    public function getBusCie10(Request $request, $bus)
    {
        if($request->ajax()){            
            $cie = Cie10::where('nombre','like',$bus.'%')
                ->orWhere('codigo','like','%'.$bus.'%')
                ->orderby('nombre','Asc')->get();
            return response()->json($cie);
        }
    }

    public function getBusCie10Codigo(Request $request, $codigo)
    {
    	if($request->ajax()){
    		$cie = Cie10::bus_codigo($codigo);
    		return response()->json($cie);
    	}
    }
}
