@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Usuario</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('usuarios.update', $usuario->IdUsuario) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 700px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="Cedula" style="font-weight: 700; color: #374151;">Cédula</label>
        <input
            type="text"
            name="Cedula"
            id="Cedula"
            value="{{ old('Cedula', $usuario->Cedula) }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Nombre" style="font-weight: 700; color: #374151;">Nombre</label>
        <input
            type="text"
            name="Nombre"
            id="Nombre"
            value="{{ old('Nombre', $usuario->Nombre) }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Apellido" style="font-weight: 700; color: #374151;">Apellido</label>
        <input
            type="text"
            name="Apellido"
            id="Apellido"
            value="{{ old('Apellido', $usuario->Apellido) }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Correo" style="font-weight: 700; color: #374151;">Correo electrónico</label>
        <input
            type="email"
            name="Correo"
            id="Correo"
            value="{{ old('Correo', $usuario->Correo) }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Telefono" style="font-weight: 700; color: #374151;">Teléfono</label>
        <input
            type="text"
            name="Telefono"
            id="Telefono"
            value="{{ old('Telefono', $usuario->Telefono) }}"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="IdInstitucion" style="font-weight: 700; color: #374151;">Institución</label>
        <select
            name="IdInstitucion"
            id="IdInstitucion"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione una institución</option>
            @foreach($instituciones->unique('Nombre') as $institucion)
                <option value="{{ $institucion->IdInstitucion }}" {{ $usuario->IdInstitucion == $institucion->IdInstitucion ? 'selected' : '' }}>
                    {{ $institucion->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="IdRol" style="font-weight: 700; color: #374151;">Rol</label>
        <select
            name="IdRol"
            id="IdRol"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->IdRol }}" {{ $usuario->IdRol == $rol->IdRol ? 'selected' : '' }}>
                    {{ $rol->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="Clave" style="font-weight: 700; color: #374151;">Nueva Contraseña (opcional)</label>
        <input
            type="password"
            name="Clave"
            id="Clave"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
        <small style="color: #6b7280;">Deja este campo vacío si no deseas cambiar la contraseña</small>
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="Clave_confirmation" style="font-weight: 700; color: #374151;">Confirmar Nueva Contraseña</label>
        <input
            type="password"
            name="Clave_confirmation"
            id="Clave_confirmation"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
    >
        💾 Actualizar Usuario
    </button>
</form>
@endsection
