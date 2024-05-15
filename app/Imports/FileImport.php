<?php

namespace App\Imports;

use App\Models\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;
use Carbon\Carbon;



class FileImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsFailures;
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

        $fecha = $this->tryGetExcelDate($row['fecha']);
        if ($fecha === null) {
            return null;
        }

        return new File([
            'fecha' => $this->tryGetExcelDate($row['fecha']),
            'folio' => $row['folio'],
            'distrito' => $row['distrito'],
            'cantidad_detenidos' => $this->tryConvertItToNumber($row['cantidad_de_detenidos']),
            'nombre' => $row['nombre_s'],
            'calle_1' => isset($row['calle_1']) ? $row['calle_1'] : $row['calle'],
            'cruce_2' => isset($row['cruce_2']) ? $row['calle_2'] : '',
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

    public function tryGetExcelDate($excelDate)
    {
        try {
            if (is_numeric($excelDate)) {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
                return \Carbon\Carbon::parse($date);
            }
            if (is_string($excelDate) && Carbon::hasFormat($excelDate, 'Y-m-d')) {
                return \Carbon\Carbon::parse($excelDate);
            }
            return null;
        } catch (\Exception $e) {
            Log::info('Error al convertir a fecha: ' . $excelDate . ' - ' . $e->getMessage());
            return null;
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
        Log::error('Error during import: ' . $e->getMessage());
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            // Log each failure message or handle it as needed
            Log::warning('Validation failure on row ' . $failure->row() . ': ' . implode(', ', $failure->errors()));
        }
    }
}
