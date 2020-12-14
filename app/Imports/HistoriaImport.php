<?php

namespace App\Imports;

use App\Http\Models\Historia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use App\Http\Models\Producto;
use App\Http\Models\Paciente;
use App\Http\Models\Doctor;

class HistoriaImport implements ToModel, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $paciente = Paciente::where('codant',$row[0])->value('id');
        if(strlen($paciente) == 0){
            return null;
        }
        $doctor = Doctor::where('codant',$row[2])->value('id');
        $fecha = $row[24].'-'.$row[23].'-'.$row[22];
        if(strlen($row[13])==0){
            $cardio = '';
        }else{
            $cardio = 'CARDIOVASCULAR: '.trim($row[13]);
        }
        if(strlen($row[14])==0){
            $apares = '';
        }else{
            $apares = ', APARTATO RESPIRATORIO: '.trim($row[14]);
        }
        if(strlen($row[15])==0){
            $tipresp = '';
        }else{
            $tipresp = ', TIPO RESPIRACION: '.trim($row[15]);
        }
        
        $ana = $cardio.' '.$apares.' '.$tipresp;
        if($row[0] == 'codigo'){
            return null;
        }
        return new Historia([
            'paciente_id' => $paciente,
            'doctor_id' => $doctor,
            'item' => $row[1],
            'tipo' => 1,
            'tippac_id' => 1,
            'fecha' => $fecha,
            'peso' => $row[11],
            'talla' => $row[12],
            'fc' => $row[6],
            'fr' => $row[8],
            'sato2' => $row[9],
            'pa' => $row[7],
            'anammesis' => $ana,
            'plantera' => $row[18],
            'status' => 3
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }
}
