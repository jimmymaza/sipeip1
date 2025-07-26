@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Crear Usuario</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('usuarios.store') }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 700px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf

    <div style="margin-bottom: 1.5rem;">
        <label for="Cedula" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Cédula</label>
        <input
            type="text"
            name="Cedula"
            id="Cedula"
            value="{{ old('Cedula') }}"
            required
            autofocus
            maxlength="10"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Cedula'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Cedula') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Nombre" style="font-weight: 700; color: #374151;">Nombre</label>
        <input
            type="text"
            name="Nombre"
            id="Nombre"
            value="{{ old('Nombre') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Nombre'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Nombre') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Apellido" style="font-weight: 700; color: #374151;">Apellido</label>
        <input
            type="text"
            name="Apellido"
            id="Apellido"
            value="{{ old('Apellido') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Apellido'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Apellido') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Correo" style="font-weight: 700; color: #374151;">Correo electrónico</label>
        <input
            type="email"
            name="Correo"
            id="Correo"
            value="{{ old('Correo') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Correo'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Correo') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Telefono" style="font-weight: 700; color: #374151;">Teléfono</label>
        <input
            type="text"
            name="Telefono"
            id="Telefono"
            value="{{ old('Telefono') }}"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Telefono'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Telefono') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="IdInstitucion" style="font-weight: 700; color: #374151;">Institución</label>
        <select
            name="IdInstitucion"
            id="IdInstitucion"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
            <option value="" disabled selected>Seleccione una institución</option>
            @foreach($instituciones->unique('Nombre') as $institucion)
                <option value="{{ $institucion->IdInstitucion }}" {{ old('IdInstitucion') == $institucion->IdInstitucion ? 'selected' : '' }}>
                    {{ $institucion->Nombre }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('IdInstitucion'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('IdInstitucion') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="IdRol" style="font-weight: 700; color: #374151;">Rol</label>
        <select
            name="IdRol"
            id="IdRol"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
            <option value="" disabled selected>Seleccione un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->IdRol }}" {{ old('IdRol') == $rol->IdRol ? 'selected' : '' }}>
                    {{ $rol->Nombre }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('IdRol'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('IdRol') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="Clave" style="font-weight: 700; color: #374151;">Contraseña</label>
        <input
            type="password"
            name="Clave"
            id="Clave"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
        @if ($errors->has('Clave'))
            <p style="color: red; margin-top: 0.3rem;">{{ $errors->first('Clave') }}</p>
        @endif
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="Clave_confirmation" style="font-weight: 700; color: #374151;">Confirmar Contraseña</label>
        <input
            type="password"
            name="Clave_confirmation"
            id="Clave_confirmation"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
    </div>

    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
    >
        💾 Guardar Usuario
    </button>
</form>
@endsection
