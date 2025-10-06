<main>
    <div class="fixed inset-0 z-50 flex items-center justify-center">
    {{-- FONDO --}}
    <div class="absolute inset-0 bg-black/50" wire:click="$set('showParticipantesModal', false)"></div>

    {{-- CONTENIDO --}}
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-4xl p-6">
        <div class="flex items-start justify-between mb-4">
        <h3 class="text-lg font-semibold">
            Gestionar participantes — {{ $eventoSeleccionado->titulo ?? '' }}
        </h3>
        <button class="text-gray-500 hover:text-gray-700" wire:click="$set('showParticipantesModal', false)">✕</button>
        </div>

        {{-- Buscador --}}
        <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Buscar participante</label>
        <input type="text"
                wire:model.debounce.500ms="searchParticipante"
                placeholder="Nombre, apellidos o email..."
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
        <p class="text-xs text-gray-500 mt-1">Empieza a escribir para ver resultados (máximo 10).</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Resultados de búsqueda (disponibles) --}}
        <div>
            <h4 class="font-semibold mb-2">Resultados</h4>
            <div class="border rounded">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-3 py-2">Nombre</th>
                    <th class="text-left px-3 py-2">Email</th>
                    <th class="px-3 py-2"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($participantesDisponibles as $p)
                    <tr class="border-t">
                    <td class="px-3 py-2">{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                    <td class="px-3 py-2">{{ $p->email }}</td>
                    <td class="px-3 py-2 text-right">
                        <button wire:click="asignarParticipante({{ $p->id }})"
                                class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                        Agregar
                        </button>
                    </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-3 py-4 text-center text-gray-500">Sin resultados</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- Asignados al evento --}}
        <div>
            <h4 class="font-semibold mb-2">Asignados al evento</h4>
            <div class="border rounded">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-3 py-2">Nombre</th>
                    <th class="text-left px-3 py-2">Email</th>
                    <th class="px-3 py-2"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($participantesAsignados as $p)
                    <tr class="border-t">
                    <td class="px-3 py-2">{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                    <td class="px-3 py-2">{{ $p->email }}</td>
                    <td class="px-3 py-2 text-right">
                        <button wire:click="quitarParticipante({{ $p->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                        Quitar
                        </button>
                    </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-3 py-4 text-center text-gray-500">Aún no hay asignados</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
        </div>

        <div class="mt-6 text-right">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                wire:click="$set('showParticipantesModal', false)">
            Cerrar
        </button>
        </div>
    </div>
    </div>
</main>