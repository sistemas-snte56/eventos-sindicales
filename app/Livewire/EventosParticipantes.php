<?php

namespace App\Livewire;

use App\Models\Evento;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Participante;
use Livewire\WithPagination;

class EventosParticipantes extends Component
{
    // * WithPagination nos permite paginar resultados en Livewire
    use WithPagination;

    public $show = false;
    public $eventoSeleccionado;

    // ! Eliminamos temporal esta línea por nueva funcion
    // public $participantesAsignados;
    // public $participantesDisponibles;

    // #[\Livewire\Attributes\On('abrir-modal-participantes')]
    #[On('abrir-modal-participantes')]
    public function abrirModal($eventoId)
    {
        // Reinicia la paginación al abrir el modal
        $this->resetPage();

        // Esta línea carga los participantes asignados al evento
        $this->eventoSeleccionado = Evento::with('participantes')->find($eventoId);
        
        $this->show = true;



/*

        //  Esta línea carga el evento seleccionado
        $this->eventoSeleccionado = Evento::find($eventoId);

        
        //  Esta línea carga los participantes asignados al evento, ordenados por nombre
        $this->participantesAsignados = $this->eventoSeleccionado->participantes()->orderBy('nombre')->get();

        //  Esta línea carga los participantes disponibles (no asignados al evento)
        $this->participantesDisponibles = Participante::whereNotIn(
            'id', 
            $this->participantesAsignados->pluck('id')
            )->orderBy('nombre')->get();

*/        
        

    }    

    public function cerrarModal()
    {
        $this->reset([
            'show', 
            'eventoSeleccionado', 
        ]);
    }    

    public function asignarParticipante($participanteId)
    {
        $this->eventoSeleccionado->participantes()->attach($participanteId, [
            'registrado_por' => auth()->id(),
        ]);

        // Refrescamos los datos sin cerrar el modal
        $this->eventoSeleccionado->load('participantes');
    }

    public function removerParticipante($participanteId)
    {
        $this->eventoSeleccionado->participantes()->detach($participanteId);

        // Refrescamos los datos sin cerrar el modal
        $this->eventoSeleccionado->load('participantes');
    }

    public function getParticipantesAsignadosProperty()
    {
        return $this->eventoSeleccionado
            // $this->eventoSeleccionado->participantes()->orderBy('nombre')->get()
            ? $this->eventoSeleccionado->participantes()->paginate(5)
            : collect();
    }

    public function getParticipantesDisponiblesProperty()
    {
        if (!$this->eventoSeleccionado) {
            return collect();
        }

        $asignadosIds = $this->eventoSeleccionado->participantes->pluck('id');

        return Participante::whereNotIn('id', $asignadosIds)
            ->orderBy('nombre')
            // ->paginate(5);
            ->paginate(5, ['*'], 'pageDisponibles');
    }


    public function render()
    {
        // return view('livewire.eventos-participantes');
        return view('livewire.eventos-participantes', [
            'participantesAsignados' => $this->participantesAsignados,
            'participantesDisponibles' => $this->participantesDisponibles,
        ]);
    }    
}