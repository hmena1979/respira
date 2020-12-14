<?php

namespace App\Imports;

use App\Http\Models\Composicion;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Http\Models\Tipmed;

class ComposicionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $id = Tipmed::where('codant', $row[0])->value('id');
        if($id === null){
            return null;
        }
        if($row[0] == 'Tipo'){
            return null;
        }


        $id = Tipmed::where('codant', $row[0])->value('id');
        return new Composicion([
            'tipmed_id' => $id,
            'nombre' => $row[2],
            'codant' => $row[1],
        ]);
    }
}
