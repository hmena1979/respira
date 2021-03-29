<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Models\Nosotro;
use App\Http\Models\Especialidad;
use App\Http\Models\Servicio;
use App\Http\Models\Sede;
use App\Http\Models\Noticia;
use App\Http\Models\Imgprin;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getWelcome()
    {
    	$nos = Nosotro::find('1');
    	$esp = Especialidad::where('activo','1')->orderBy('orden')->get();
        // $ser = Especialidad::where('activo','1')->orderBy('orden')->get();
        $sed = Sede::where('activo','1')->orderBy('orden')->get();
        $not = Noticia::where('activo','1')->orderBy('orden')->take(3)->get();
        $imp = Imgprin::where('activo','1')->orderBy('orden')->get();
    	$data = [
            'nos'=>$nos,
            'esp'=>$esp,
            // 'ser'=>$ser,
            'sed'=>$sed,
            'not'=>$not,
            'imp'=>$imp
        ];
    	return view('welcome', $data);
    }

    public function getEspecialidad($id)
    {
    	$esp1 = Especialidad::find($id);
    	$esp = Especialidad::where('activo','1')->get();
    	$nos = Nosotro::find('1');
        $sed = Sede::where('activo','1')->get();
    	$data = [
    		'esp1'=>$esp1,
            'esp'=>$esp,
            'nos'=>$nos,
            'sed'=>$sed
        ];
    	return view('especialidades', $data);
    }

    public function getServicio($id)
    {
        $ser1 = Servicio::find($id);
        $esp = Especialidad::where('activo','1')->get();
        $sed = Sede::where('activo','1')->get();
        $nos = Nosotro::find('1');
        $data = [
            'ser1'=>$ser1,
            'sed'=>$sed,
            'esp'=>$esp,
            'nos'=>$nos
        ];
        return view('servicio', $data);
    }

    public function getSede($id)
    {
        $sede = Sede::find($id);
        $sed = Sede::where('activo','1')->get();
        $nos = Nosotro::find('1');
        $esp = Especialidad::where('activo','1')->get();
        $data = [
            'sede'=>$sede,
            'sed'=>$sed,
            'nos'=>$nos,
            'esp'=>$esp,
            
        ];
        return view('sede', $data);
    }


    
}
