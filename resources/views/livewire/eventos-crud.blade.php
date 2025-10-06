<main>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Eventos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Gestión de Eventos
                    </h1>

                    @if (session()->has('message'))
                        <div class="p-2 bg-green-200 text-green-800 rounded mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <button wire:click="create"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded mb-4 me-2">
                        Crear evento
                    </button>
            
                    @if($isOpen)
                        @include('livewire.eventos-modal')
                    @endif
            
                    <table class="w-full border mb-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">ID</th>
                                <th class="border px-2 py-1">Título</th>
                                <th class="border px-2 py-1">Fecha</th>
                                <th class="border px-2 py-1">Lugar</th>
                                <th class="border px-2 py-1">Modalidad</th>
                                <th class="border px-2 py-1">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                                <tr>
                                    <td class="border px-2 py-1">{{ $evento->id }}</td>
                                    <td class="border px-2 py-1">{{ $evento->titulo }}</td>
                                    <td class="border px-2 py-1">{{ $evento->fecha_inicio }}</td>
                                    <td class="border px-2 py-1">{{ $evento->sede }}</td>
                                    <td class="border px-2 py-1">{{ $evento->modalidad }}</td>
                                    <td class="border px-2 py-1">
                                        <button wire:click="edit({{ $evento->id }})"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">
                                            Editar
                                        </button>
                                        <button wire:click="delete({{ $evento->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                                            Eliminar
                                        </button>
                                        <button wire:click="manageParticipants({{ $evento->id }})"
                                            class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
                                            Participantes
                                        </button>                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                {{-- @include('livewire.eventos-participantes-modal') --}}



                
            </div>
        </div>
    </div>
</main>