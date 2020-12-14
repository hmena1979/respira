<?php

namespace App\Imports;

use App\Http\Models\Servicio;
use Maatwebsite\Excel\Concerns\ToModel;

class ServicioImport implements ToModel
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
        return new Servicio([
            'codant' => $row[0],
            'nombre' => $row[1],
            'precio' => $row[2],
            'clinica' => $row[3],
            'especialista' => $row[4]
        ]);
    }
}
