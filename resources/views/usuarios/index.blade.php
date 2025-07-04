@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1rem;">Gestión de Usuarios</h2>

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 1rem;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('usuarios.create') }}" style="background-color: #10b981; color: white; padding: 8px 12px; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-block; margin-bottom: 1rem;">
    ➕ Crear Usuario
</a>

<table style="width: 100%; border-collapse: collapse;">
    <thead style="background-color: #374151; color: white;">
        <tr>
            <th style="padding: 8px; text-align: left;">ID</th>
            <th style="padding: 8px; text-align: left;">Nombre Completo</th>
            <th style="padding: 8px; text-align: left;">Cédula</th>
            <th style="padding: 8px; text-align: left;">Teléfono</th>
            <th style="padding: 8px; text-align: left;">Email</th>
            <th style="padding: 8px; text-align: left;">Rol</th>
            <th style="padding: 8px; text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px;">{{ $usuario->id }}</td>
            <td style="padding: 8px;">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
            <td style="padding: 8px;">{{ $usuario->cedula }}</td>
            <td style="padding: 8px;">{{ $usuario->telefono }}</td>
            <td style="padding: 8px;">{{ $usuario->email }}</td>
            <td style="padding: 8px;">{{ $usuario->rol }}</td>
            <td style="padding: 8px; text-align: center;">
                <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}" title="Editar" style="color: #3b82f6; margin-right: 8px;">✏️</a>

                <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;" title="Eliminar">🗑️</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
