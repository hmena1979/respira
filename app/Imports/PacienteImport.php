<?php

namespace App\Imports;

use App\Http\Models\Paciente;
use App\Http\Models\Doctor;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Str;

class PacienteImport implements ToModel, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(strlen($row[48])==0){
            $doctor_id = 1;
        }else{
            $doctor_id = Doctor::where('codant', $row[48])->value('id');
            if(strlen($doctor_id)==0){
                $doctor_id = 1;
            }
        }

        if($row[0] == 'codigo'){
            return null;
        }

        if($row[16] == 1):
            $sexo = 'M';
        else:
            $sexo = 'F';
        endif;
        switch ($row[17]){
            case '1':
                $estciv_id = '1';
                break;
            case '2':
                $estciv_id = '2';
                break;
            case '3':
                $estciv_id = '3';
                break;
            case '4':
                $estciv_id = '4';
                break;
            default:
                $estciv_id = '1';
        }
        $antecedentes = [
			'dm' => ($row[23]==1)? true:false,
            'hta' => ($row[25]==1)? true:false,
            'neumonia' => ($row[27]==1)? true:false,
            'tbc' => ($row[29]==1)? true:false,
            'asma' => ($row[31]==1)? true:false,
            'tabaco' => ($row[33]==1)? true:false,
            'covid19' => false,
            'ehlc' => ($row[35]==1)? true:false
        ];
        $alergia = [
			'polvo' => ($row[37]==1)? true:false,
            'humedad' => ($row[38]==1)? true:false,
            'polen' => ($row[39]==1)? true:false,
            'medicamentos' => ($row[40]==1)? true:false,
            'desotros' => trim(Str::upper(($row[42])))
        ];
        $antecedentes = json_encode($antecedentes);
        $alergia = json_encode($alergia);
        if(strlen($row[57])<>0){
            $fecnac = $row[57].'-'.$row[56].'-'.$row[55];
        }else{
            $fecnac = null;
        }
        if(strlen($row[54])<>0){
            $fecing = $row[54].'-'.$row[53].'-'.$row[52];
        }else{
            $fecing = null;
        }

        return new Paciente([
            'codant' => $row[0],
            'historia' => $row[1],
            'tipdoc_id' => $row[2],
            'numdoc' => trim($row[3]),
            'ape_pat' => trim($row[5]),
            'ape_mat' => trim($row[6]),
            'nombre1' => trim($row[7]),
            'nombre2' => trim($row[8]),
            'razsoc' => trim($row[9]),
            'fecnac' => $fecnac,
            'fecing' => $fecing,
            'sexo_id' => $sexo,
            'estciv_id' => $estciv_id,
            'ocupacion' => trim($row[18]),
            'lorigen' => trim($row[20]),
            'lresidencia' => trim($row[21]),
            'responsable' => trim($row[22]),
            'direccion' => trim($row[10]),
            'telefono' => trim($row[11]),
            'email' => trim($row[46]),
            'antecedentes' => $antecedentes,
            'alergia' => $alergia,
            'tie_enfer' => trim($row[44]),
            'tenfact' => trim($row[45]),
            'doctor_id' => $doctor_id,
            'tippac_id' => '1'
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }
}
