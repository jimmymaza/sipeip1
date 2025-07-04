@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1rem; font-weight: 700;">Crear Nuevo Usuario</h2>

@if ($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #f87171;">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul style="margin-top: 8px; margin-left: 18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('usuarios.store') }}" method="POST" style="max-width: 600px; background: #f9fafb; padding: 20px 25px; border-radius: 10px; box-shadow: 0 6px 15px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
    @csrf

    <label for="nombre" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 14px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

    <label for="apellido" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Apellido</label>
    <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 14px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

    <label for="cedula" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Cédula</label>
    <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 14px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

    <label for="telefono" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Teléfono</label>
    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 14px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

    <label for="email" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Correo electrónico</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 14px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

    <label for="rol" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Rol</label>
    <select name="rol" id="rol" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 20px; font-size: 1rem; background-color: white;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">
        <option value="" disabled selected>Seleccione un rol</option>
        @foreach($roles as $rol)
            <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>{{ $rol }}</option>
        @endforeach
    </select>

    <label for="password" style="display: block; margin-bottom: 6px; font-weight: 700; color: #374151;">Contraseña</label>
    <input type="password" name="password" id="password" required
        style="width: 100%; padding: 8px 12px; border: 2px solid #cbd5e1; border-radius: 8px; margin-bottom: 20px; font-size: 1rem;"
        onfocus="this.style.borderColor='#2563eb';" onblur="this.style.borderColor='#cbd5e1';">

   <button type="submit" 
         style="width: 30%; background-color:rgb(21, 88, 234); color: white; padding: 5px 12px; font-weight: 700; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1rem; transition: background-color 0.3s ease;">
         Guardar Usuario
    </button>
</form>
@endsection
