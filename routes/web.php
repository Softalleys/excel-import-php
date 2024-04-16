<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('index');
})-> name('index');
Route::post('import', [FileController::class, 'import'])->name('import');
