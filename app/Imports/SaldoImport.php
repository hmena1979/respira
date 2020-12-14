<?php

namespace App\Imports;

use App\Http\Models\Saldo;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Http\Models\Producto;
use App\Http\Models\Vencimiento;

class SaldoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $producto = Producto::where('codant',$row[0])->value('id');

        if($row[0] == 'codigo'){
            return null;
        }

        if($row[2] <> 0){
            Vencimiento::insert([
                'producto_id'=>$producto,
                'lote'=>$row[3],
                'vencimiento'=>$row[4],
                'entradas'=>$row[2],
                'salidas'=>0,
                'saldo'=>$row[2]
                ]);
        }
        
        return new Saldo([
            'periodo' => '000000',
            'producto_id' => $producto,
            'inicial' => $row[2],
            'saldo' => $row[2],
            'precio' => $row[5],
        ]);
    }
}
