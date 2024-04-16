<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('fecha');
            $table->string('folio') -> unique();
            $table->string('distrito');
            $table->integer('cantidad_detenidos');
            $table->string('nombre');
            $table->string('calle_1');
            $table->string('cruce_2');
            $table->string('colonia');
            $table->string('altitud');
            $table->string('latitud');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
