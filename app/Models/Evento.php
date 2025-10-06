<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria_id',
        'sede',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'responsable_id',
        'modalidad',
        'estado'
    ];

    public function responsable()
    { 
        return $this->belongsTo(User::class, 'responsable_id'); 
    }

    public function participantes()
    { 
        return $this->belongsToMany(Participante::class, 'evento_participante')
                ->withPivot(['asistencia','hora_entrada','hora_salida','calificacion','folio','certificado_uuid','certificado_hash','certificado_emitido_at'])
                ->withTimestamps(); 
    }    
}
