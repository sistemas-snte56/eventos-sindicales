<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Evento;
use Livewire\Component;
use App\Models\Participante;
use Livewire\Attributes\Url;
use Livewire\WithPagination;


class EventosCrud extends Component
{


    use WithPagination;

    public $eventoSeleccionado;
    public $participantesDisponibles;
    public $participantesAsignados;
    public $showParticipantesModal = false;
    
    public $searchParticipante = '';


    public $categorias;
    public $usuarios;

    public $titulo,
           $descripcion,
           $categoria_id,
           $sede,
           $fecha_inicio,
           $fecha_fin,
           $hora_inicio,
           $hora_fin,
           $responsable_id,
           $cupo,
           $modalidad ,
           $estado,
           $eventos,
           $evento_id,
           $isOpen = false;
    
    public function mount()
    {
        $this->participantesDisponibles = collect();
        $this->participantesAsignados = collect();
        $this->usuarios = User::all();
    }

    public function render()
    {
        $this->eventos = Evento::all();

        if ($this->searchParticipante) {
            $this->participantesDisponibles = Participante::where(function($q) {
                $q->where('nombre', 'like', "%{$this->searchParticipante}%")
                ->orWhere('apaterno', 'like', "%{$this->searchParticipante}%")
                ->orWhere('amaterno', 'like', "%{$this->searchParticipante}%")
                ->orWhere('email', 'like', "%{$this->searchParticipante}%");
            })
            ->whereNotIn('id', $this->participantesAsignados->pluck('id'))
            ->limit(10)
            ->get();
        } else {
            $this->participantesDisponibles = collect();
        }
                
        return view('livewire.eventos-crud')->layout('layouts.app'); 
    }

    public function create()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    private function resetInputFields()
    {
        $this->titulo = '';
        $this->descripcion = '';
        $this->categoria_id = '';
        $this->sede = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->responsable_id = '';
        $this->cupo = '';
        $this->modalidad = 'presencial';
        $this->estado = 'borrador';
        $this->evento_id = '';
    }

    private function validateData()
    {
        return $this->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'sede' => 'required',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable',
            'categoria_id' => 'nullable|exists:categorias,id',
            'responsable_id' => 'required|exists:users,id',
            'cupo' => 'nullable|integer|min:1',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'estado' => 'required|in:borrador,publicado,cerrado',
        ], [
            'titulo.required' => 'El campo título es obligatorio.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'sede.required' => 'El campo sede es obligatorio.',
            'fecha_inicio.required' => 'El campo fecha de inicio es obligatorio.',
            'hora_inicio.required' => 'El campo hora de inicio es obligatorio.',
            'responsable_id.required' => 'El campo responsable es obligatorio.',
        ]);
    }

    public function store()
    {
        $this->validateData();

        Evento::create([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'sede' => $this->sede,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'categoria_id' => $this->categoria_id ?: null,
            'responsable_id' => $this->responsable_id,
            'cupo' => $this->cupo,
            'modalidad' => $this->modalidad,
            'estado' => $this->estado,
        ]);

        session()->flash('message', 'Evento creado correctamente.');

        $this->resetInputFields();
        $this->closeModal();
    }

    public function update()
    {
        $this->validateData();

        $evento = Evento::findOrFail($this->evento_id);

        $evento->update([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'sede' => $this->sede,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'categoria_id' => $this->categoria_id ?: null,
            'responsable_id' => $this->responsable_id,
            'cupo' => $this->cupo,
            'modalidad' => $this->modalidad,
            'estado' => $this->estado,
        ]);

        session()->flash('message', 'Evento actualizado correctamente.');

        $this->resetInputFields();
        $this->closeModal();
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);

        $this->evento_id = $evento->id;
        $this->titulo = $evento->titulo;
        $this->descripcion = $evento->descripcion;
        $this->sede = $evento->sede;
        $this->fecha_inicio = $evento->fecha_inicio;
        $this->fecha_fin = $evento->fecha_fin;
        $this->hora_inicio = $evento->hora_inicio;
        $this->hora_fin = $evento->hora_fin;
        $this->categoria_id = $evento->categoria_id;
        $this->responsable_id = $evento->responsable_id;
        $this->cupo = $evento->cupo;
        $this->modalidad = $evento->modalidad;
        $this->estado = $evento->estado;

        $this->resetErrorBag();
        $this->openModal();
    }

    public function delete($id)
    {
        Evento::findOrFail($id)->delete();
        session()->flash('message', 'Evento eliminado correctamente.');
    }










    public function manageParticipants($eventoId)
    {
        $this->eventoSeleccionado = Evento::with('participantes')->findOrFail($eventoId);

        $this->participantesAsignados = $this->eventoSeleccionado->participantes ?? collect();
        $this->searchParticipante = ''; // limpiar búsqueda
        $this->participantesDisponibles = collect(); // se cargan en render cuando hay búsqueda
        $this->showParticipantesModal = true;
    }

    public function asignarParticipante($participanteId)
    {
        if (!$this->eventoSeleccionado->participantes->contains($participanteId)) {
            $this->eventoSeleccionado->participantes()->attach($participanteId, [
                'registrado_por' => auth()->id(),
            ]);
        }
        $this->manageParticipants($this->eventoSeleccionado->id); // refrescar datos
    }

    public function quitarParticipante($participanteId)
    {
        $this->eventoSeleccionado->participantes()->detach($participanteId);
        $this->manageParticipants($this->eventoSeleccionado->id);
    }












}
