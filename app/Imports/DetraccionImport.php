<?php

namespace App\Imports;

use App\Http\Models\Detraccion;
use Maatwebsite\Excel\Concerns\ToModel;

class DetraccionImport implements ToModel
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
        return new Detraccion([
            'codigo' => $row[0],
            'nombre' => $row[1],
            'porcentaje' => $row[2]

        ]);
    }
}
