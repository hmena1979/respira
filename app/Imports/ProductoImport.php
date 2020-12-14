<?php

namespace App\Imports;

use App\Http\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Http\Models\Tipmed;
use App\Http\Models\Composicion;
use App\Http\Models\Umedida;
use App\Http\Models\Laboratorio;

class ProductoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tipmed = Tipmed::where('codant', $row[1])->value('id');
        $composicion = Composicion::where('codant', $row[2])->value('id');
        $laboratorio = Laboratorio::where('codant', $row[3])->value('id');
        $umedida = Umedida::where('codant', $row[5])->value('id');

        if($row[0] == 'codigo'){
            return null;
        }

        $id = Tipmed::where('codant', $row[0])->value('id');
        return new Producto([
            'codant' => $row[0],
            'tipmed_id' => $tipmed,
            'composicion_id' => $composicion,
            'laboratorio_id' => $laboratorio,
            'nombre' => trim($row[4]),
            'umedida_id' => $umedida,
            'stock' => $row[6],
            'stockmin' => $row[7],
            'precompra' => $row[8],
            'afecto' => 1,
            'premerca' => $row[11],
            'porganancia' => $row[13]
        ]);
        //return new Producto([

            //['nombre','codant','tipmed_id','umedida_id',
        //'stock','stockmin','precompra','afecto','composicion_id','laboratorio_id','premerca','porganancia'];
        //]);
    }
}
