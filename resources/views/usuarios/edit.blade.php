@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1rem;">Editar Usuario</h2>

@if($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 1rem;">
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" style="background-color: #f9fafb; padding: 1.5rem; border-radius: 8px; max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1rem;">
        <label for="nombre" style="display: block; font-weight: 600;">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="apellido" style="display: block; font-weight: 600;">Apellido</label>
        <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $usuario->apellido) }}" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="cedula" style="display: block; font-weight: 600;">Cédula</label>
        <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $usuario->cedula) }}" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="telefono" style="display: block; font-weight: 600;">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="email" style="display: block; font-weight: 600;">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="rol" style="display: block; font-weight: 600;">Rol</label>
        <select name="rol" id="rol" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
            <option value="">Seleccione un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol }}" {{ old('rol', $usuario->rol) === $rol ? 'selected' : '' }}>{{ $rol }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="password" style="display: block; font-weight: 600;">Nueva Contraseña (opcional)</label>
        <input type="password" name="password" id="password" placeholder="Dejar en blanco si no desea cambiar" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <button type="submit" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
        💾 Guardar Cambios
    </button>
</form>
@endsection
