<?php

namespace App\Imports;

use App\Http\Models\Tipmed;
use Maatwebsite\Excel\Concerns\ToModel;

class TipmedImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'Codigo'){
            return null;
        }
        return new Tipmed([
            'codant' => $row[0],
            'nombre' => $row[1]
        ]);
    }
}
