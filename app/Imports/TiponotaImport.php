<?php

namespace App\Imports;

use App\Http\Models\Tiponota;
use Maatwebsite\Excel\Concerns\ToModel;
use Str;

class TiponotaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'comprobante'){
            return null;
        }
        return new Tiponota([
            'comprobante_id' => $row[0],
            'codigo' => $row[1],
            'nombre' => Str::upper($row[2])
        ]);
    }
}
