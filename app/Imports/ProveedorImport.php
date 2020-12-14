<?php

namespace App\Imports;

use App\Http\Models\Paciente;
use Maatwebsite\Excel\Concerns\ToModel;

class ProveedorImport implements ToModel
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
        $numdoc = trim($row[3]);
        if(strlen($numdoc) >= 11){
            $tipdoc = '6';
        }else{
            $tipdoc = '1';
        }

        if($tipdoc == '6' && substr($numdoc, 0, 2) == '20'){
            $ape_pat = "";
            $ape_mat = "";
            $nombre1 = "";
            $nombre2 = "";
            $razsoc = trim($row[9]);
        }else{
            $ape_pat = trim($row[5]);
            $ape_mat = trim($row[6]);
            $nombre1 = trim($row[7]);
            $nombre2 = trim($row[8]);
            $razsoc = trim($row[9]);
        }

        return new Paciente([
            'codant' => $row[0],
            'tipo' => 2,
            'tipdoc_id' => $tipdoc,
            'numdoc' => $numdoc,
            'ape_pat' => $ape_pat,
            'ape_mat' => $ape_mat,
            'nombre1' => $nombre1,
            'nombre2' => $nombre2,
            'razsoc' => $razsoc,
            'direccion' => trim($row[10]),
            'telefono' => trim($row[11]),
            'email' => trim($row[46]),
        ]);
    }
}
