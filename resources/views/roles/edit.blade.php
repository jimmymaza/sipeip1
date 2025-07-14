@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Rol</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('roles.update', $rol->IdRol) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="Nombre" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Nombre del Rol</label>
        <input 
            type="text" 
            name="Nombre" 
            id="Nombre" 
            value="{{ old('Nombre', $rol->Nombre) }}" 
            required 
            autofocus
            aria-required="true"
            aria-describedby="nombreHelp"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
        <small id="nombreHelp" style="color: #6b7280;">Ejemplo: Administrador, Editor, Usuario</small>
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="Descripcion" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Descripción</label>
        <textarea 
            name="Descripcion" 
            id="Descripcion" 
            required 
            aria-required="true"
            rows="4"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; resize: vertical; transition: border-color 0.3s ease;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >{{ old('Descripcion', $rol->Descripcion) }}</textarea>
    </div>

    <button 
        type="submit" 
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none; transition: background-color 0.3s ease;"
        onmouseover="this.style.backgroundColor='#1d4ed8'"
        onmouseout="this.style.backgroundColor='#2563eb'"
        aria-label="Actualizar rol"
    >
        💾 Actualizar Rol
    </button>
</form>
@endsection
