<?php

namespace App\Imports;

use App\Http\Models\Comprobante;
use Maatwebsite\Excel\Concerns\ToModel;

class ComprobanteImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'codigo'){
            return null;
        }
        return new Comprobante([
            'codigo' => $row[0],
            'nombre' => $row[1],
            'sigla' => $row[2],
            'activo' => $row[3]
        ]);
    }
}
