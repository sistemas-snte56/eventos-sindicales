<?php

namespace App\Livewire;

use App\Models\Region;
use Livewire\Component;
use App\Models\Delegacion;
use App\Models\Participante;
use Livewire\Attributes\Url;

class ParticipantesCrud extends Component
{


    /*

        'delegacion_id', 'rfc', 'nombre', 'apaterno', 'amaterno',
        'genero', 'email', 'npersonal', 'telefono', 'ct',
        'cargo', 'nivel', 'curp', 'folio', 'slug',
        'codigo_id', 'codigo_qr', 'talon', 'ine_frontal', 'ine_reverso','colonia_id',
        'calle','colonia','cp',


    */


    // Datos Laborales
    public $isOpen = false, $regiones, $region_id, $delegaciones=[], $delegacion_id, $npersonal, $nivel, $participantes, $participante_id;

    // Datos Personales
    public $rfc, $nombre, $apaterno, $amaterno, $genero, $email, $telefono, $ct, $cargo, $curp;
    public $folio, $slug, $codigo_id, $codigo_qr, $talon, $ine_frontal, $ine_reverso;
    public $colonia_id, $calle, $colonia, $cp;  


    public function mount()
    {
        $this->regiones = Region::all();
    }

    public function render()
    {
        $this->participantes = Participante::all();
        return view('livewire.participantes-crud')->layout('layouts.app'); 
    }

    public function create()
    {
        $this->resetErrorBag();
        $this->openModal();
    }

    public function updatedRegionId($region_id)
    {
        $this->delegaciones = Delegacion::where('region_id', $region_id)->orderBy('delegacion','asc')->get();
        $this->delegacion_id = null;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
        $this->resetErrorBag();
    }

    public function resetInputFields()
    {
        // Datos Laborales
        $this->region_id = '';
        $this->delegacion_id = '';
        $this->npersonal = '';
        $this->nivel = '';
        $this->participante_id = '';

        // Datos Personales
        $this->rfc = '';
        $this->nombre = '';
        $this->apaterno = '';
        $this->amaterno = '';
        $this->genero = '';
        $this->email = '';
        $this->telefono = '';
        $this->ct = '';
        $this->cargo = '';
        $this->curp = '';

        $this->folio = '';
        $this->slug = '';
        $this->codigo_id = '';
        $this->codigo_qr = '';
        $this->talon = '';
        $this->ine_frontal = '';
        $this->ine_reverso = '';

        $this->colonia_id = '';
        $this->calle = '';
        $this->colonia = '';
        $this->cp = '';  
    }

    private function generateFolio($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function generateSlug($name) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        return $slug;
    }

    private function formatearNombre($texto)
    {
        $excepciones = ['de', 'del', 'la', 'los', 'las', 'y'];
        
        // Convertimos todo a minúsculas primero
        $palabras = explode(' ', mb_strtolower($texto, 'UTF-8'));

        // Recorremos y capitalizamos, excepto las palabras en la lista de excepciones
        $palabras = array_map(function ($palabra) use ($excepciones) {
            return in_array($palabra, $excepciones)
                ? $palabra
                : mb_convert_case($palabra, MB_CASE_TITLE, 'UTF-8');
        }, $palabras);

        // Siempre capitalizamos la primera palabra (aunque sea una preposición)
        $palabras[0] = mb_convert_case($palabras[0], MB_CASE_TITLE, 'UTF-8');

        return implode(' ', $palabras);        
    }

    private function validateData()
    {
        return $this->validate([
            // 'region_id' => 'required|exists:regiones,id',
            'delegacion_id' => 'required|exists:delegaciones,id',
            'npersonal' => 'required|numeric',
            'nivel' => 'required|string|max:50',

            // 'rfc' => 'required|string|max:13|unique:participantes,rfc,' . $this->participante_id,
            'rfc' => 'required|string|max:13|unique:participantes,rfc|regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i',
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'nullable|string|max:100',
            'genero' => 'required|in:hombre,mujer,no_binario,prefiero_no_decirlo', 
            'email' => 'required|email|max:150|unique:participantes,email,' . $this->participante_id,
            'telefono' => 'required|digits:10',
            // 'ct' => 'nullable|string|max:100',
            // 'cargo' => 'nullable|string|max:100',
            // 'curp' => 'nullable|string|max:18|unique:participantes,curp,' . $this->participante_id,

            // 'colonia_id' => 'nullable|exists:colonias,id',
            // 'calle' => 'nullable|string|max:150',
            // 'colonia' => 'nullable|string|max:150',
            // 'cp' => 'nullable|string|max:10',  
        ],[
            'delegacion_id.required' => 'El campo delegación es obligatorio.',
            'npersonal.required' => 'El campo número de personal es obligatorio.',
            'npersonal.numeric' => 'El campo número de personal debe ser numérico.',
            'nivel.required' => 'El campo nivel es obligatorio.',
            'rfc.required' => 'El campo RFC es obligatorio.',
            'rfc.regex' => 'El formato del RFC es inválido.',
            'rfc.unique' => 'El RFC ya está registrado.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apaterno.required' => 'El campo apellido paterno es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.digits' => 'El campo teléfono debe ser numérico.',
            'genero.required' => 'El campo género es obligatorio.',
            'genero.in' => 'El campo género seleccionado es inválido.',
        ]);
    }

    public function store()
    {
        $this->validateData();

        $folio = $this->generateFolio(8);
        $slug = $this->generateSlug($this->nombre . ' ' . $this->apaterno . ' ' . ($this->amaterno ?? ''));

        Participante::create([
            'delegacion_id' => $this->delegacion_id,
            'rfc' => strtoupper($this->rfc),
            'nombre' => $this->formatearNombre($this->nombre),
            'apaterno' => $this->formatearNombre($this->apaterno),
            'amaterno' => $this->formatearNombre($this->amaterno),
            'email' => $this->email,
            'npersonal' => $this->npersonal,
            'nivel' => $this->nivel,
            'telefono' => $this->telefono,
            'genero' => $this->genero,
            'folio' => $folio,
            'slug' => $slug,
            // 'ct' => $this->ct,
            // 'cargo' => $this->cargo,
            // 'curp' => $this->curp,
            // 'codigo_id' => $this->codigo_id, // Generar código QR
            // 'codigo_qr' => $this->codigo_qr, // Generar código QR
            // 'talon' => $this->talon, // Generar talón de registro
            // 'ine_frontal' => $this->ine_frontal, // Subir imagen INE frontal
            // 'ine_reverso' => $this->ine_reverso, // Subir imagen INE reverso
            // 'colonia_id' => $this->colonia_id,
            // 'calle' => $this->calle,
            // 'colonia' => $this->colonia,
            // 'cp' => $this->cp,  
        ]);

        session()->flash('message','¡Participante creado exitosamente!');
        // session()->flash('message', 
        //     $this->participante_id ? '¡Participante actualizado exitosamente!' : '¡Participante creado exitosamente!');

        $this->closeModal();
        $this->resetInputFields();
        return redirect()->to('/participantes');
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $participante = Participante::findOrFail($id);
        $this->participante_id = $id;

        $this->region_id = $participante->delegacion->region_id;
        $this->updatedRegionId($this->region_id); // Cargar delegaciones
        $this->delegacion_id = $participante->delegacion_id;
        $this->npersonal = $participante->npersonal;
        $this->nivel = $participante->nivel;

        $this->rfc = $participante->rfc;
        $this->nombre = $participante->nombre;
        $this->apaterno = $participante->apaterno;
        $this->amaterno = $participante->amaterno;
        $this->genero = $participante->genero;
        $this->email = $participante->email;
        $this->telefono = $participante->telefono;
        // $this->ct = $participante->ct;
        // $this->cargo = $participante->cargo;
        // $this->curp = $participante->curp;

        // $this->folio = $participante->folio;
        // $this->slug = $participante->slug;
        // $this->codigo_id = $participante->codigo_id;
        // $this->codigo_qr = $participante->codigo_qr;
        // $this->talon = $participante->talon;
        // $this->ine_frontal = $participante->ine_frontal;
        // $this->ine_reverso = $participante->ine_reverso;

        // $this->colonia_id = $participante->colonia_id;
        // $this->calle = $participante->calle;
        // $this->colonia = $participante->colonia;
        // $this->cp = $participante->cp;  

        $this->openModal();
    }   

    public function update()
    {
        $this->validateData();

        $participante = Participante::findOrFail($this->participante_id);

        $participante->update([
            'delegacion_id' => $this->delegacion_id,
            'rfc' => strtoupper($this->rfc),
            'nombre' => $this->formatearNombre($this->nombre),
            'apaterno' => $this->formatearNombre($this->apaterno),
            'amaterno' => $this->formatearNombre($this->amaterno),
            'email' => $this->email,
            'npersonal' => $this->npersonal,
            'nivel' => $this->nivel,
            'telefono' => $this->telefono,
            'genero' => $this->genero,
            // 'ct' => $this->ct,
            // 'cargo' => $this->cargo,
            // 'curp' => $this->curp,
            // 'codigo_id' => $this->codigo_id, // Generar código QR
            // 'codigo_qr' => $this->codigo_qr, // Generar código QR
            // 'talon' => $this->talon, // Generar talón de registro
            // 'ine_frontal' => $this->ine_frontal, // Subir imagen INE frontal
            // 'ine_reverso' => $this->ine_reverso, // Subir imagen INE reverso
            // 'colonia_id' => $this->colonia_id,
            // 'calle' => $this->calle,
            // 'colonia' => $this->colonia,
            // 'cp' => $this->cp,  
        ]);

        session()->flash('message','¡Participante actualizado exitosamente!');
        // session()->flash('message', 
        //     $this->participante_id ? '¡Participante actualizado exitosamente!' : '¡Participante creado exitosamente!');

        $this->closeModal();
        $this->resetInputFields();
        return redirect()->to('/participantes');
    }

    public function delete($id)
    {
        $participante = Participante::findOrFail($id);
        $participante->delete();
        session()->flash('message', 'Participante eliminado correctamente.');  
        return redirect()->to('/participantes');
    }
}
