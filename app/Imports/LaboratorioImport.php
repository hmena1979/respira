<?php

namespace App\Imports;

use App\Http\Models\Laboratorio;
use Maatwebsite\Excel\Concerns\ToModel;

class LaboratorioImport implements ToModel
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
        return new Laboratorio([
            'codant' => $row[0],
            'nombre' => $row[1]
        ]);
    }
}
