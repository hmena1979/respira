<?php

namespace App\Imports;

use App\Http\Models\Cie10;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Cie10Import implements ToModel, WithBatchInserts
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

        return new Cie10([
            'codigo' => $row[0],
            'nombre' => $row[1]
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }
}
