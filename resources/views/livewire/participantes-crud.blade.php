<main>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Participantes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Gestión de Participantes
                    </h1>

                    @if (session()->has('message'))
                        <div class="p-2 bg-green-200 text-green-800 rounded mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <button wire:click="create"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded mb-4 me-2">
                        Nuevo participante
                    </button>

                    @if($isOpen)
                        @include('livewire.participantes-modal')
                    @endif


                    <table class="w-full border mb-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">ID</th>
                                <th class="border px-2 py-1">Región</th>
                                <th class="border px-2 py-1">Delegación</th>
                                <th class="border px-2 py-1">Nombre</th>
                                <th class="border px-2 py-1">Apellidos</th>
                                <th class="border px-2 py-1">Email</th>
                                <th class="border px-2 py-1">Teléfono</th>
                                <th class="border px-2 py-1">RFC</th>
                                <th class="border px-2 py-1">Configuración</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participantes as $participante)
                                <tr>
                                    <td class="border px-2 py-1">{{ $participante->id }}</td>
                                    <td class="border px-2 py-1">{{ $participante->delegacion->region->region }} {{ $participante->delegacion->region->sede }} </td>
                                    <td class="border px-2 py-1">{{ $participante->delegacion->delegacion }}</td>
                                    <td class="border px-2 py-1">{{ $participante->nombre }}</td>
                                    <td class="border px-2 py-1">{{ $participante->apaterno }} {{ $participante->amaterno }}</td>
                                    <td class="border px-2 py-1">{{ $participante->email }}</td>
                                    <td class="border px-2 py-1">{{ $participante->telefono }}</td>
                                    <td class="border px-2 py-1">{{ $participante->rfc }}</td>
                                    <td class="border px-2 py-1">
                                        <button wire:click="edit({{ $participante->id }})"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">
                                            Editar
                                        </button>
                                        <button wire:click="delete({{ $participante->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    

                </div>
            </div>
        </div>
    </div>
</main>