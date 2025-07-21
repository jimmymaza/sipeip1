<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte {{ ucfirst(str_replace('_', ' ', $tipo)) }}</title>
    <style>
        /* Reset box-sizing para todo */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #374151;
            margin: 40px auto;
            background-color: #f3f4f6;
            max-width: 1100px;
            padding: 0 20px;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            color: #2563eb; /* azul vibrante */
            border-bottom: 3px solid #2563eb;
            padding-bottom: 12px;
            font-weight: 700;
            text-transform: capitalize;
            letter-spacing: 0.03em;
            user-select: none;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.15);
            border-radius: 10px;
            overflow: hidden;
            font-size: 13.5px;
        }

        thead tr {
            background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.05em;
        }

        thead th {
            padding: 14px 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            user-select: none;
        }
        thead th:last-child {
            border-right: none;
        }

        tbody tr {
            transition: background-color 0.3s ease;
            cursor: default;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #eff6ff;
        }

        tbody td {
            padding: 14px 20px;
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
        }
        tbody td:last-child {
            border-right: none;
        }

        /* Mensaje sin datos */
        .no-data {
            text-align: center;
            font-style: italic;
            color: #9ca3af;
            padding: 30px 0;
            font-size: 15px;
            font-weight: 600;
            user-select: none;
        }
    </style>
</head>
<body>

    <h2>Reporte: {{ ucfirst(str_replace('_', ' ', $tipo)) }}</h2>

    @if($datos->isEmpty())
        <div class="no-data">
            ¡Sin resultados! No hay datos para mostrar con este filtro.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    @switch($tipo)
                        @case('usuarios')
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Institución</th>
                            <th>Rol</th>
                            <th>Fecha Creación</th>
                            @break

                        @case('planes')
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            @break

                        @case('objetivos_institucionales')
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            @break

                        @case('proyectos')
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            @break

                        @default
                            <th>ID</th>
                            <th>Nombre</th>
                    @endswitch
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $dato)
                    <tr>
                        @switch($tipo)
                            @case('usuarios')
                                <td>{{ $dato->id }}</td>
                                <td>{{ trim(($dato->Nombre ?? $dato->name) . ' ' . ($dato->Apellido ?? '')) }}</td>
                                <td>{{ $dato->Correo ?? $dato->email }}</td>
                                <td>{{ optional($instituciones->firstWhere('IdInstitucion', $dato->IdInstitucion))->Nombre ?? 'N/A' }}</td>
                                <td>{{ optional($roles->firstWhere('IdRol', $dato->IdRol))->NombreRol ?? 'N/A' }}</td>
                                <td>{{ $dato->FechaCreacion ?? optional($dato->created_at)->format('Y-m-d') }}</td>
                                @break

                            @case('planes')
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->codigo }}</td>
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ $dato->descripcion }}</td>
                                <td>{{ ucfirst($dato->estado) }}</td>
                                <td>{{ $dato->fecha_inicio }}</td>
                                <td>{{ $dato->fecha_fin }}</td>
                                @break

                            @case('objetivos_institucionales')
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ $dato->descripcion }}</td>
                                <td>{{ ucfirst($dato->estado) }}</td>
                                @break

                            @case('proyectos')
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ $dato->descripcion }}</td>
                                <td>{{ ucfirst($dato->estado) }}</td>
                                <td>{{ $dato->fecha_inicio }}</td>
                                <td>{{ $dato->fecha_fin }}</td>
                                @break

                            @default
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->nombre }}</td>
                        @endswitch
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
