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
        Schema::create('evento_participante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->unsignedBigInteger('participante_id'); // referencia a participantes.id o users.id
            $table->foreign('participante_id')->references('id')->on('participantes'); // cambia a users si aplica
            $table->foreignId('registrado_por')->nullable()->constrained('users');
            $table->boolean('asistencia')->default(false);
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->unsignedTinyInteger('calificacion')->nullable();
            $table->string('folio')->nullable()->unique();
            $table->uuid('certificado_uuid')->nullable()->unique();
            $table->string('certificado_hash', 64)->nullable();
            $table->timestamp('certificado_emitido_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_participante');
    }
};
