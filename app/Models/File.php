<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'folio',
        'distrito',
        'cantidad_detenidos',
        'nombre',
        'calle_1',
        'cruce_2',
        'colonia',
        'altitud',
        'latitud',
        'observaciones',
    ];
}
