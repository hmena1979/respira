<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Paciente;
use App\Http\Models\Historia;
use App\Http\Models\Param;

use Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('isadmin');
    }

    public function getDashboard()
    {
        if(Auth::user()->doctor_id == 1){
            $historias = Historia::with(['pac','sta','tip','dr'])
            ->join('pacientes','historias.paciente_id','pacientes.id')
            ->select('historias.id','historias.paciente_id','historias.item','historias.status','historias.tipo','historias.doctor_id')
            ->where('historias.fecha', session('fecha'))
            ->orderBy('historias.doctor_id')
            ->orderBy('pacientes.razsoc')
            ->get();
        }else{
            $historias = Historia::with(['pac','sta','tip','dr'])
            ->join('pacientes','historias.paciente_id','pacientes.id')
            ->select('historias.id','historias.paciente_id','historias.item','historias.status','historias.tipo','historias.doctor_id')
            ->where('historias.doctor_id',Auth::user()->doctor_id)
            ->where('historias.fecha', session('fecha'))
            ->orderBy('historias.doctor_id')
            ->orderBy('pacientes.razsoc')
            ->get();
        }
        
        $data = [
            'historias' => $historias
        ];
        return view('admin.dashboard', $data);
    }

    public function postDashboardCambio(Request $request)
    {
        session(['fecha' => $request->input('fecha')]);
        if(Auth::user()->doctor_id == 1){
            $historias = Historia::with(['pac','sta','tip','dr'])
            ->join('pacientes','historias.paciente_id','pacientes.id')
            ->select('historias.id','historias.paciente_id','historias.item','historias.status','historias.tipo','historias.doctor_id')
            ->where('historias.fecha', session('fecha'))
            ->orderBy('historias.doctor_id')
            ->orderBy('pacientes.razsoc')
            ->get();
        }else{
            $historias = Historia::with(['pac','sta','tip','dr'])
            ->join('pacientes','historias.paciente_id','pacientes.id')
            ->select('historias.id','historias.paciente_id','historias.item','historias.status','historias.tipo','historias.doctor_id')
            ->where('historias.doctor_id',Auth::user()->doctor_id)
            ->where('historias.fecha', session('fecha'))
            ->orderBy('historias.doctor_id')
            ->orderBy('pacientes.razsoc')
            ->get();
        }
        // $historias = Historia::with(['pac','sta','tip','dr'])->select('id','paciente_id','item','status','tipo','doctor_id')
        //     ->where('fecha', session('fecha'))
        //     ->orderBy('doctor_id')
        //     ->get();
        $data = [
            'historias' => $historias
        ];
        return view('admin.dashboard', $data);
    }
}
