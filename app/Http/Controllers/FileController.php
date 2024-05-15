<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\FileImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function import()
    {
        $request = Request::capture();
        Log::info($request);
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        // $validator = Validator::make($request->all(), [
        //     'fecha' => 'exists:files,fecha',
        //     'folio' => 'exists:files,folio',
        //     'distrito' => 'exists:files,distrito',
        //     'cantidad_detenidos' => 'exists:files,cantidad_detenidos',
        //     'nombre' => 'exists:files,nombre',
        //     'calle_1' => 'exists:files,calle_1',
        //     'cruce_2' => 'exists:files,cruce_2',
        //     'colonia' => 'exists:files,colonia',
        //     'altitud' => 'exists:files,altitud',
        //     'latitud' => 'exists:files,latitud',
        //     'observaciones' => 'exists:files,observaciones',
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'status' => 422,
        //         'errors' => $validator->messages()
        //     ], 422);
        // }else{
            
            $file = $request->file('file');
            Excel::import(new FileImport, $file);
    
            return redirect()->route('index')->with('success', 'File imported successfully!');
        // }
    }
}
