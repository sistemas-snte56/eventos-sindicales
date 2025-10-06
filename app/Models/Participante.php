<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participantes';

    protected $fillable = [
        'delegacion_id', 'rfc', 'nombre', 'apaterno', 'amaterno',
        'genero', 'email', 'npersonal', 'telefono', 'ct',
        'cargo', 'nivel', 'curp', 'folio', 'slug',
        'codigo_id', 'codigo_qr', 'talon', 'ine_frontal', 'ine_reverso','colonia_id',
        'calle','colonia','cp',
    ];

    public function delegacion()
    {
        return $this->belongsTo(Delegacion::class);
    }
        
    // Relación: un participante pertenece a una colonia
    public function colonia()
    {
        return $this->belongsTo(Colonia::class);
    } 

    // public function eventos()
    // { return $this->belongsToMany(Event::class, 'event_participant')->withTimestamps(); }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_participante')
                    ->withPivot(['asistencia','folio','certificado_uuid','certificado_emitido_at'])
                    ->withTimestamps();
    }    

}