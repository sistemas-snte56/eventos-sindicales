<main>
    @if($show)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative">
                <button wire:click="cerrarModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

                <h3 class="text-lg font-semibold mb-4">
                    Participantes del evento:
                    <span class="text-blue-600">{{ $eventoSeleccionado->titulo ?? '' }}</span>
                </h3>
                
                {{--
                <div class="overflow-y-auto max-h-[400px] border rounded">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">RFC</th>
                                <th class="px-3 py-2 text-left">Delegación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participantes as $i => $p)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2">{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                                    <td class="px-3 py-2">{{ $p->rfc }}</td>
                                    <td class="px-3 py-2">{{ $p->delegacion->delegacion ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">No hay participantes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                --}}

                {{-- LISTA DE PARTICIPANTES ASIGNADOS --}}
                <h4 class="font-semibold text-gray-700 mb-2">Asignados</h4>
                <div class="overflow-y-auto max-h-[250px] border rounded mb-4">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">RFC</th>
                                <th class="px-3 py-2 text-left">Delegación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participantesAsignados as $i => $p)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2">{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                                    <td class="px-3 py-2">{{ $p->rfc }}</td>
                                    <td class="px-3 py-2">{{ $p->delegacion->delegacion ?? '-' }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <button wire:click="removerParticipante({{ $p->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                            Quitar
                                        </button>
                                    </td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">No hay participantes asignados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- LISTA DE PARTICIPANTES DISPONIBLES --}}
                <h4 class="font-semibold text-gray-700 mb-2">Disponibles para asignar</h4>
                <div class="overflow-y-auto max-h-[200px] border rounded">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">RFC</th>
                                <th class="px-3 py-2 text-left">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participantesDisponibles as $i => $p)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2">{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                                    <td class="px-3 py-2">{{ $p->rfc }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <button wire:click="asignarParticipante({{ $p->id }})"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                            Asignar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                        No hay participantes disponibles para asignar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación de personas --}}
                <div class="mt-2">
                    {{ $participantesDisponibles->links() }}
                </div>
                
                <div class="text-right mt-6">
                    <button wire:click="cerrarModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
</main>