<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Http\Models\Factura;
use App\Http\Models\NotaAdm;
use App\Http\Models\NotaFar;
use App\Http\Models\Salida;

class WincontallExport implements FromView
{
    protected $periodo;
    function __construct($periodo){
        $this->periodo = $periodo;
    }

    public function view(): View
    {
        $periodo = $this->periodo;
        $factura = Factura::with(['cli','det'])
            ->select('id','fecha','comprobante_id','serie','numero','ruc','tot_gravadas','tot_exoneradas',
                'tot_igv','total_clinica','moneda','tipo')
            ->where('periodo', $periodo)
            ->orderBy('comprobante_id', 'asc')
            ->orderBy('fecha', 'asc')
            ->get();
        $notaadm = NotaAdm::with(['cli','det'])
            ->select('id','fecha','comprobante_id','serie','numero','ruc','tot_gravadas','tot_exoneradas',
                'tot_igv','total','moneda','dmcomprobante_id','dmserie','dmnumero')
            ->where('periodo', $periodo)
            ->orderBy('comprobante_id', 'asc')
            ->orderBy('fecha', 'asc')
            ->get();
        $salida = Salida::with(['cli'])
            ->select('fecha','comprobante_id','serie','numero','ruc','tot_gravadas','tot_exoneradas',
                'tot_igv','total','moneda','tipo')
            ->where('comprobante_id', '01')
            ->orWhere('comprobante_id', '03')
            ->where('periodo', $periodo)
            ->orderBy('comprobante_id', 'asc')
            ->orderBy('fecha', 'asc')
            ->get();
        $notafar = NotaFar::with(['cli'])
            ->select('fecha','comprobante_id','serie','numero','ruc','tot_gravadas','tot_exoneradas',
                'tot_igv','total','moneda','dmcomprobante_id','dmserie','dmnumero')
            ->where('periodo', $periodo)
            ->orderBy('comprobante_id', 'asc')
            ->orderBy('fecha', 'asc')
            ->get();
        
        $data = [
            'factura' => $factura,
            'notaadm' => $notaadm,
            'salida' => $salida,
            'notafar' => $notafar,
            'periodo' => $periodo
        ];
        
        return view('pdf.wincontall',$data);
    }
}
