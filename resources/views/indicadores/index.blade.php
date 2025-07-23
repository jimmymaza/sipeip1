@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Listado de Indicadores</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('indicadores.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">Crear Nuevo Indicador</a>

    @if($indicadores->count() > 0)
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Descripción</th>
                <th class="border border-gray-300 px-4 py-2">Responsable</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indicadores as $indicador)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $indicador->descripcion }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $indicador->usuarioResponsable->Nombre ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-4 py-2 space-x-2">
                    <a href="{{ route('indicadores.edit', $indicador->id) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form action="{{ route('indicadores.destroy', $indicador->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este indicador?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $indicadores->links() }}
    </div>
    @else
        <p>No hay indicadores registrados.</p>
    @endif
</div>
@endsection
