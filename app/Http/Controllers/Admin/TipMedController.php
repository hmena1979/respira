<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator, Str;

use App\Http\Models\Tipmed;
use App\Http\Models\Composicion;

class TipMedController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getTipMedHome($id)
    {
        $tipmeds = Tipmed::orderBy('nombre')->get();
        $Composicions = Composicion::where('tipmed_id', $id)->orderBy('nombre','Asc')->get();
        $data = [
            'tipmeds' => $tipmeds,
            'Composicions' => $Composicions,
            'id' => $id
        ];
    	return view('admin.tipmeds.home', $data);
    }

    public function getTipMedSelComposicion(Request $request, $id)
    {
        if($request->ajax()){
    		$ddes = Composicion::where('tipmed_id',$id)->orderBy('nombre','Asc')->get();
    		return response()->json($ddes);
    	}
    }

}
