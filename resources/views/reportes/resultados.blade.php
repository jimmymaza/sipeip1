@extends('layouts.app')

@section('content')
<style>
    /* --- Estilos personalizados para el reporte --- */

    /* Contenedor principal */
    .report-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #374151;
    }

    /* Título */
    .report-title {
        font-size: 2.25rem; /* 36px */
        font-weight: 700;
        color: #4f46e5; /* indigo-700 */
        margin-bottom: 1.5rem;
        border-bottom: 4px solid #6366f1; /* indigo-500 */
        padding-bottom: 0.75rem;
        user-select: none;
    }

    /* Descripciones */
    .report-description {
        color: #4b5563; /* gray-700 */
        margin-bottom: 1rem;
        max-width: 600px;
        line-height: 1.6;
    }

    .report-subdescription {
        color: #9ca3af; /* gray-400 */
        margin-bottom: 2rem;
        max-width: 600px;
        font-size: 0.875rem; /* 14px */
    }

    /* Botones */
    .btn-primary, .btn-secondary {
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.25);
        transition: background-color 0.3s ease;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .btn-primary {
        background-color: #ef4444; /* red-500 */
        color: white;
    }

    .btn-primary:hover {
        background-color: #dc2626; /* red-600 */
    }

    .btn-secondary {
        background-color: #e0e7ff; /* indigo-100 */
        color: #4338ca; /* indigo-800 */
    }

    .btn-secondary:hover {
        background-color: #c7d2fe; /* indigo-200 */
    }

    /* Iconos en botones */
    .btn-icon {
        width: 18px;
        height: 18px;
        margin-right: 0.5rem;
        flex-shrink: 0;
        fill: currentColor;
    }

    /* Tabla */
    .table-container {
        overflow-x: auto;
        border: 1px solid #cbd5e1; /* gray-300 */
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem; /* 14.4px */
        background-color: white;
        table-layout: auto; /* para que se ajuste al contenido */
    }

    thead tr {
        background: linear-gradient(90deg, #4f46e5 0%, #4338ca 100%); /* indigo-700 a indigo-800 */
        color: white;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 0.75rem; /* 12px */
        letter-spacing: 0.05em;
        user-select: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    thead th {
        padding: 0.75rem 1.25rem;
        border-right: 1px solid rgba(255, 255, 255, 0.3);
        white-space: nowrap;
    }

    thead th:last-child {
        border-right: none;
    }

    tbody tr {
        transition: background-color 0.25s ease;
    }

    tbody tr:hover {
        background-color: #eef2ff; /* indigo-50 */
    }

    tbody td {
        padding: 0.75rem 1.25rem;
        border-right: 1px solid #e5e7eb; /* gray-200 */
        border-bottom: 1px solid #e5e7eb;
        color: #374151; /* gray-700 */
        white-space: normal; /* permite envolver texto */
        max-width: none;     /* sin límite de ancho */
        overflow-wrap: break-word; /* rompe palabras largas */
        word-wrap: break-word;     /* compatibilidad */
    }

    tbody td:last-child {
        border-right: none;
    }

    /* Mensaje sin datos */
    .no-data-container {
        text-align: center;
        padding: 4rem 1rem;
        color: #9ca3af; /* gray-400 */
        font-style: italic;
        font-weight: 600;
        font-size: 1.125rem;
        user-select: none;
    }

    /* SVG sin resultados */
    .no-data-svg {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        color: #cbd5e1; /* gray-300 */
    }

    /* Responsive ajustes */
    @media (max-width: 640px) {
        .btn-primary, .btn-secondary {
            justify-content: center;
            width: 100%;
        }

        .btn-icon {
            margin-right: 0.25rem;
            width: 16px;
            height: 16px;
        }

        thead th, tbody td {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container mx-auto py-8 px-4 max-w-5xl report-container">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="report-title">
            Reporte: {{ $titulo }}
        </h2>

        <p class="report-description">
            Datos filtrados según el tipo de reporte seleccionado.
        </p>
        <p class="report-subdescription">
            Si no ves información, no hay datos disponibles con ese filtro.
        </p>

        @if($datos->isEmpty())
            <div class="no-data-container">
                <svg xmlns="http://www.w3.org/2000/svg" class="no-data-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M9 12l2 2 4-4" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
                ¡Sin resultados!
                <br>
                No hay datos para mostrar con este filtro.
                <br><br>
                <a href="{{ route('reportes.index') }}" class="btn-secondary">
                    ← Volver a Reportes
                </a>
            </div>
        @else
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <a href="{{ route('reportes.index') }}" class="btn-secondary whitespace-nowrap">
                    ← Volver a Reportes
                </a>

                <form action="{{ route('reportes.generar') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <input type="hidden" name="action" value="pdf">
                    <input type="hidden" name="institucion_id" value="{{ request('institucion_id') }}">
                    <input type="hidden" name="rol_id" value="{{ request('rol_id') }}">
                    <input type="hidden" name="estado" value="{{ request('estado') }}">
                    <input type="hidden" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    <input type="hidden" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                    <button type="submit" class="btn-primary flex items-center justify-center whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon" fill="currentColor" viewBox="0 0 24 24" stroke="none" aria-hidden="true">
                            <path d="M12 2a2 2 0 0 0-2 2v6h-2v2h2v6a2 2 0 1 0 4 0v-6h2v-2h-2V4a2 2 0 0 0-2-2z"/>
                        </svg>
                        Exportar a PDF
                    </button>
                </form>
            </div>

            <div class="table-container rounded-lg shadow-sm">
                <table>
                    <thead>
                        <tr>
                            @foreach(array_keys($datos->first()->toArray()) as $columna)
                                <th>{{ ucfirst(str_replace('_', ' ', $columna)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $fila)
                            <tr>
                                @foreach($fila->toArray() as $valor)
                                    <td>
                                        {{ is_string($valor) ? $valor : json_encode($valor) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
  
</script>
@endsection
