<?php

namespace App\Imports;

use App\Http\Models\Vencimiento;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Http\Models\Producto;

class VencimientoImport implements ToModel
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
        return new Vencimiento([
            'producto_id' => $producto,
            'lote' => $row[3],
            'vencimiento' => $row[4],
            'entradas' => $row[2],
            'saldo' => $row[2],
        ]);
    }
}
