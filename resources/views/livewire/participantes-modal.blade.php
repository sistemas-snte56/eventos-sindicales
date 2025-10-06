<main>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow p-6 w-2/3">
            <h3 class="text-lg font-bold mb-4">
                {{ $participante_id ? 'Editar participante' : 'Nuevo participante' }}
            </h3>

            <form wire:submit.prevent="{{ $participante_id ? 'update' : 'store' }}">
                {{-- Datos laborales --}}
                <p class="text-[#ee7a00] text-lg font-bold mt-4 mb-2">Datos laborales</p>
                <div class="flex gap-4 mb-4">
                    <!-- Región -->
                    <div class="w-[40%]">
                        <label class="block mb-1">Región</label>
                        <select wire:model.live="region_id" class="w-full border rounded px-2 py-1">
                            <option value="">-- Seleccione región --</option>
                            @foreach($regiones as $region)
                                <option value="{{ $region->id }}">{{ $region->region }} - {{ $region->sede }}</option>
                            @endforeach
                        </select>
                        @error('region_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Delegación -->
                    <div class="w-[60%]">
                        <label class="block mb-1">Delegación</label>
                        <select wire:model.live="delegacion_id" class="w-full border rounded px-2 py-1">
                            <option value="">-- Seleccione delegación --</option>
                            @foreach($delegaciones as $delegacion)
                                <option value="{{ $delegacion->id }}">{{ $delegacion->delegacion }} {{ $delegacion->sede }}</option>
                            @endforeach
                        </select>
                        @error('delegacion_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-4 mb-4">
                    {{-- Número de personal --}}
                    <div class="w-[50%]">
                        <label class="block mb-1">Número de personal</label>
                        <input type="text" wire:model="npersonal" class="w-full border rounded px-2 py-1">
                        @error('npersonal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nivel --}}
                    <div class="w-[50%]">
                        <label class="block mb-1">Nivel</label>
                        <select wire:model="nivel" class="w-full border rounded px-2 py-1">
                            <option value="">-- Seleccione nivel --</option>
                            @foreach ([
                                'Preescolar', 'Primaria', 'Educación Especial', 'Secundaria', 'Telesecundaria',
                                'Educación Física', 'Niveles Especiales', 'Paae', 'Bachillerato', 'Telebachillerato',
                                'Normales', 'UPV', 'Jubilados'
                            ] as $nivelOption)
                                <option value="{{ $nivelOption }}">{{ $nivelOption }}</option>
                            @endforeach
                        </select>
                        @error('nivel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Datos laborales --}}
                <p class="text-[#ee7a00] text-lg font-bold mt-4 mb-2">Datos Personales</p>                
                <div class="flex gap-4 mb-4">
                    {{-- Nombre --}}
                    <div class="w-[25%]">
                        <label class="block mb-1">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full border rounded px-2 py-1">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Apellido Paterno --}}      
                    <div class="w-[25%]">
                        <label class="block mb-1">Apellido Paterno</label>
                        <input type="text" wire:model="apaterno" class="w-full border rounded px-2 py-1">
                        @error('apaterno') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror   
                    </div>

                    {{-- Apellido Materno --}}
                    <div class="w-[25%]">
                        <label class="block mb-1">Apellido Materno</label>
                        <input type="text" wire:model="amaterno" class="w-full border rounded px-2 py-1">
                        @error('amaterno') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Género --}}
                    <div class="w-[25%]">
                        <label class="block mb-1">Género</label>
                        <select wire:model="genero" class="w-full border rounded px-2 py-1">
                            <option value="">-- Seleccione género --</option>
                            @foreach ([
                                'hombre' => 'Hombre',
                                'mujer' => 'Mujer',
                                'no_binario' => 'No binario',
                                'prefiero_no_decirlo' => 'Prefiero no decirlo'
                            ] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('genero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>                    
                </div>


                <div class="flex gap-4 mb-4">
                    <!-- RFC -->
                    <div class="w-[22.22%]">
                        <label class="block mb-1">RFC</label>
                        <input type="text" wire:model="rfc" class="w-full border rounded px-2 py-1">
                        @error('rfc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="w-[33.33%]">
                        <label class="block mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full border rounded px-2 py-1">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror  
                    </div>

                    <!-- Teléfono -->
                   <div class="w-[44.45%]">
                       <label class="block">Teléfono</label>
                       <input type="text" wire:model="telefono" class="w-full border rounded px-2 py-1">
                       @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                   </div>
                </div>    

                <!-- Botones -->
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Guardar
                    </button>
                </div>
            </form>

        </div>
    </div>
</main>