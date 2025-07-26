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

        /* Formato básico para impresión A4 */
        @page {
            size: A4;
            margin: 20mm 15mm 20mm 15mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            font-size: 20pt;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: capitalize;
            user-select: none;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-bottom: 1.5rem;
        }

        thead tr {
            background-color: #ccc;
        }

        thead th {
            padding: 8px 10px;
            border: 1px solid #999;
            text-align: left;
            user-select: none;
        }

        tbody td {
            padding: 8px 10px;
            border: 1px solid #999;
            vertical-align: top;
            word-wrap: break-word;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Mensaje sin datos */
        .no-data {
            text-align: center;
            font-style: italic;
            color: #555;
            padding: 30px 0;
            font-size: 14pt;
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
        <table id="reporteTabla">
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
