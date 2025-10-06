<main>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow p-6 w-1/2">
            <h3 class="text-lg font-bold mb-4">
                {{ $evento_id ? 'Editar Evento' : 'Nuevo Evento' }}
            </h3>

            <form wire:submit.prevent="{{ $evento_id ? 'update' : 'store' }}">

                <!-- Título -->
                <div class="mb-4">
                    <label class="block">Título</label>
                    <input type="text" wire:model="titulo" class="w-full border rounded px-2 py-1">
                    @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label class="block">Descripción</label>
                    <textarea wire:model="descripcion" class="w-full border rounded px-2 py-1"></textarea>
                    @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Sede -->
                <div class="mb-4">
                    <label class="block">Sede</label>
                    <input type="text" wire:model="sede" class="w-full border rounded px-2 py-1">
                    @error('sede') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Fecha inicio -->
                <div class="mb-4">
                    <label class="block">Fecha de inicio</label>
                    <input type="date" wire:model="fecha_inicio" class="w-full border rounded px-2 py-1">
                    @error('fecha_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Fecha fin -->
                <div class="mb-4">
                    <label class="block">Fecha de fin</label>
                    <input type="date" wire:model="fecha_fin" class="w-full border rounded px-2 py-1">
                    @error('fecha_fin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Hora inicio -->
                <div class="mb-4">
                    <label class="block">Hora de inicio</label>
                    <input type="time" wire:model="hora_inicio" class="w-full border rounded px-2 py-1">
                    @error('hora_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Hora fin -->
                <div class="mb-4">
                    <label class="block">Hora de fin</label>
                    <input type="time" wire:model="hora_fin" class="w-full border rounded px-2 py-1">
                    @error('hora_fin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Categoría -->
                {{-- <div class="mb-4">
                    <label class="block">Categoría</label>
                    <select wire:model="categoria_id" class="w-full border rounded px-2 py-1">
                        <option value="">-- Seleccione categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div> --}}

                <!-- Responsable -->
                <div class="mb-4">
                    <label class="block">Responsable</label>
                    <select wire:model="responsable_id" class="w-full border rounded px-2 py-1">
                        <option value="">-- Seleccione responsable --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                    @error('responsable_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Modalidad -->
                <div class="mb-4">
                    <label class="block">Modalidad</label>
                    <select wire:model="modalidad" class="w-full border rounded px-2 py-1">
                        <option value="" selected>-- Seleccione modalidad --</option>
                        <option value="presencial">Presencial</option>
                        <option value="virtual">Virtual</option>
                        <option value="mixta">Mixta</option>
                    </select>
                    @error('modalidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <label class="block">Estado</label>
                    <select wire:model="estado" class="w-full border rounded px-2 py-1">
                        <option value="" selected>-- Seleccione estado --</option>
                        <option value="borrador">Borrador</option>
                        <option value="publicado">Publicado</option>
                        <option value="cerrado">Cerrado</option>
                    </select>
                    @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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