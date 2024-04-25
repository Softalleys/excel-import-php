<?php

namespace App\Imports;

use App\Models\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;


class FileImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    private $folios = [];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    * @return int
    */
    public function model(array $row)
    {
        if (in_array($row['folio'], $this->folios)) {
            return null;
        }
        $this->folios[] = $row['folio'];

        return new File([
            'fecha' => $this->tryGetExcelDate($row['fecha']),
            'folio' => $row['folio'],
            'distrito' => $row['distrito'],
            'cantidad_detenidos' => $this->tryConvertItToNumber($row['cantidad_de_detenidos']),
            'nombre' => $row['nombre_s'],
            'calle_1' => $row['calle_1'],
            'cruce_2' => $row['cruce_2'],
            'colonia' => $row['colonia'],
            'altitud' => $row['altitud'],
            'latitud' => $row['latitud'],
            'observaciones' => $row['observaciones'],
        ]);
    }

    public function tryConvertItToNumber($excelNumber): int
    {
        try {
            return intval($excelNumber);
        } catch (\Exception) {
            Log::info('Error al convertir a número: ' . $excelNumber);
            return 1;
        }
    }

    public function tryGetExcelDate($excelDate): \Carbon\Carbon|string
    {
        try {
             $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
             // To Carbon
            return \Carbon\Carbon::parse($date);
        } catch (\Exception) {
            Log::info('Error al convertir a fecha: ' . $excelDate);
            return $excelDate;
        }
    }

    public function rules(): array
    {
        return [
            'folio' => 'unique:files,folio',
        ];
    }

    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

    public function onFailure(Failure ...$failures)
    {
        // TODO: Implement onFailure() method.
    }
}
