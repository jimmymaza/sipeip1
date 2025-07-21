@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-blue-800 mb-6">Reporte: {{ $titulo }}</h2>
        
        <p class="text-gray-700 mb-4">
            Aquí se muestran los datos filtrados según el tipo de reporte seleccionado.
        </p>
        <p class="text-sm text-gray-500 mb-6">
            Si no ves información, no hay datos disponibles con ese filtro.
        </p>

        @if($datos->isEmpty())
            <div class="text-center py-20">
                <p class="text-xl font-semibold text-gray-600 mb-6">¡Sin resultados!</p>
                <p class="text-gray-500 mb-8">No hay datos para mostrar con este filtro.</p>
                <a href="{{ route('reportes.index') }}"
                   class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-3 px-6 rounded-full shadow-md transition">
                    ← Volver a Reportes
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-md rounded-xl">
                    <thead class="bg-blue-100 text-blue-900 uppercase text-sm font-semibold">
                        <tr>
                            @foreach(array_keys($datos->first()->toArray()) as $columna)
                                <th class="px-6 py-3 text-left whitespace-nowrap">{{ ucfirst(str_replace('_', ' ', $columna)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($datos as $fila)
                            <tr class="hover:bg-gray-50 transition">
                                @foreach($fila->toArray() as $valor)
                                    <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ is_string($valor) ? $valor : json_encode($valor) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Botones de acción --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mt-10 gap-4">
                <a href="{{ route('reportes.index') }}"
                   class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-3 px-6 rounded-full shadow-md transition">
                    ← Volver a Reportes
                </a>

                <form action="{{ route('reportes.generar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    {{-- Pasamos todos los filtros actuales --}}
                    <input type="hidden" name="action" value="pdf">
                    <input type="hidden" name="institucion_id" value="{{ request('institucion_id') }}">
                    <input type="hidden" name="rol_id" value="{{ request('rol_id') }}">
                    <input type="hidden" name="estado" value="{{ request('estado') }}">
                    <input type="hidden" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    <input type="hidden" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                    <button type="submit"
                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition">
                        <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
