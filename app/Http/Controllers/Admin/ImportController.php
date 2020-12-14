<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator, Str;

use App\Http\Models\Umedida;
use App\Http\Models\Doctor;
use App\Http\Models\Correlativo;

use App\Imports\CategoriaImport;
use App\Imports\Cie10Import;
use App\Imports\TipmedImport;
use App\Imports\ComposicionImport;
use App\Imports\ProductoImport;
use App\Imports\LaboratorioImport;
use App\Imports\DoctorImport;
use App\Imports\PacienteImport;
use App\Imports\ServicioImport;
use App\Imports\ProveedorImport;
use App\Imports\ComprobanteImport;
use App\Imports\AfectacionImport;
use App\Imports\TiponotaImport;
use App\Imports\DetraccionImport;
use App\Imports\SaldoImport;
use App\Imports\VencimientoImport;
use App\Imports\HistoriaImport;

class ImportController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getImportHome()
    {
        return view('admin.import.home');
    }

    public function postImportCategoria(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Categoría.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new CategoriaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function postImportCie10(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo CIE10.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new Cie10Import, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function postImportTipMed(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo TipMedica.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new TipmedImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function postImportComposicion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Composicion.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ComposicionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function getImportUMedida()
    {
        Umedida::insert(['codant'=>'01','nombre'=>'JARABE','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'02','nombre'=>'TABLETA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'03','nombre'=>'GRAGEA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'04','nombre'=>'CAPSULA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'05','nombre'=>'AMPOLLA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'06','nombre'=>'INHALADOR','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'07','nombre'=>'SPRAY NASAL','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'08','nombre'=>'SOBRES','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'09','nombre'=>'GOTAS','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'10','nombre'=>'CAJA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'11','nombre'=>'CAP INH','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'12','nombre'=>'AEROCAMARA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'13','nombre'=>'MASCARA NEBULIZADORA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'14','nombre'=>'UNIDAD','sunat'=>'94','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'15','nombre'=>'FRASCO','sunat'=>'VI','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'16','nombre'=>'SUSPENSION','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'17','nombre'=>'JERINGA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'18','nombre'=>'BOLSA','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'19','nombre'=>'CAPSULA EN GEL','sunat'=>'NIU']);
        Umedida::insert(['codant'=>'20','nombre'=>'LATA','sunat'=>'NIU']);
		Umedida::insert(['codant'=>'21','nombre'=>'BOTELLA','sunat'=>'NIU']);
		
		// Correlativo::insert(['index'=>'HISTORIA','descripcion'=>'Historia clínica','valor'=>0]);
		// Correlativo::insert(['index'=>'B001','descripcion'=>'Boleta admisión','valor'=>0]);
		// Correlativo::insert(['index'=>'F001','descripcion'=>'Factura admisión','valor'=>0]);
		// Correlativo::insert(['index'=>'B002','descripcion'=>'Boleta farmacia','valor'=>0]);
		// Correlativo::insert(['index'=>'F002','descripcion'=>'Factura farmacia','valor'=>0]);
		

        return redirect('/admin/import')->with('message', 'Registros importados')->with('typealert', 'success');
    }

    public function postImportProducto(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Productos.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ProductoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function postImportLaboratorio(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Laboratorioss.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new LaboratorioImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportDoctor(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Doctor.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
			Doctor::insert(['nombre'=>'SIN ASIGNAR']);
    		$file = $request->file('archivo');
    		Excel::import(new DoctorImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportPaciente(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Paciente.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new PacienteImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}

	public function postImportProveedor(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Proveedores.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ProveedorImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportServicio(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Servicios.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ServicioImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportComprobante(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Comprobantes.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ComprobanteImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportAfectacion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Afectacion.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new AfectacionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportTipoNota(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo TipoNota.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new TiponotaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportDetraccion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Detracciones.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new DetraccionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportSaldo(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Saldo.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new SaldoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportVence(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Vencimiento.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new VencimientoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}
	
	public function postImportHistoria(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Historia.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new HistoriaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }


}
