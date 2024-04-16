<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function import()
    {
        $request = Request::capture();
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        Excel::import(new FileImport, $file);

        return redirect()->route('index')->with('success', 'File imported successfully!');
    }
}
