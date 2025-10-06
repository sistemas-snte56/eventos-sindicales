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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delegacion_id')->constrained('delegaciones')->onDelete('cascade'); // nombre corregido
            $table->string('rfc')->unique();
            $table->string('nombre');
            $table->string('apaterno');
            $table->string('amaterno');
            $table->enum('genero', ['hombre', 'mujer', 'no_binario', 'prefiero_no_decirlo']);
            $table->string('email')->unique();
            $table->string('npersonal',50)->nullable();
            $table->string('telefono')->nullable();
            $table->string('ct')->nullable();
            $table->string('cargo')->nullable();
            $table->enum('nivel', [
                'Preescolar',
                'Primaria',
                'Educación Especial',
                'Secundaria',
                'Telesecundaria',
                'Educación Física',
                'Niveles Especiales',
                'Paae',
                'Bachillerato',
                'Telebachillerato',
                'Normales',
                'UPV',
                'Jubilados'
            ])->nullable();
            $table->string('curp')->nullable();
            $table->string('unidad')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->foreignId('colonia_id')->constrained('colonias')->onDelete('cascade');
            $table->string('calle')->nullable();
            $table->string('folio', 50)->nullable();
            $table->string('slug')->unique();
            $table->string('codigo_id', 250)->nullable();
            $table->string('codigo_qr')->nullable();
            $table->string('talon')->nullable();
            $table->string('ine_frontal')->nullable();
            $table->string('ine_reverso')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
