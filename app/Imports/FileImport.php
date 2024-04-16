<?php

namespace App\Imports;

use App\Models\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class FileImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    * @return int
    */
    public function model(array $row)
    {
        return new File([
            'fecha' => $row['fecha'],
            'folio' => $row['folio'],
            'distrito' => $row['distrito'],
            'cantidad_detenidos' => $row['cantidad_de_detenidos'],
            'nombre' => $row['nombre_s'],
            'calle_1' => $row['calle_1'],
            'cruce_2' => $row['cruce_2'],
            'colonia' => $row['colonia'],
            'altitud' => $row['altitud'],
            'latitud' => $row['latitud'],
            'observaciones' => $row['observaciones'],
        ]);
    }
}
