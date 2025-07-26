@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Crear Objetivo</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside; margin: 0; padding-left: 1rem;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $fechaRegistro = old('fecha_registro') ? \Carbon\Carbon::parse(old('fecha_registro'))->format('Y-m-d\TH:i') : '';
@endphp

<form action="{{ route('objetivos.store', ['tipo' => $tipo]) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf

    {{-- Código --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="codigo" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Código del Objetivo</label>
        <input
            type="text"
            name="codigo"
            id="codigo"
            value="{{ old('codigo') }}"
            required
            autofocus
            aria-required="true"
            aria-describedby="codigoHelp"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
        <small id="codigoHelp" style="color: #6b7280;">Ejemplo: OBJ-001</small>
    </div>

    {{-- Nombre --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="nombre" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Nombre del Objetivo</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            value="{{ old('nombre') }}"
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    {{-- Descripción --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="descripcion" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Descripción del Objetivo</label>
        <textarea
            name="descripcion"
            id="descripcion"
            rows="4"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease; resize: vertical;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >{{ old('descripcion') }}</textarea>
    </div>

    {{-- Tipo (campo oculto) --}}
    <input type="hidden" name="tipo" value="{{ $tipo }}">

    {{-- Estado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="estado" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Estado</label>
        <select
            name="estado"
            id="estado"
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; background-color: white;"
        >
            <option value="" disabled {{ old('estado') === null ? 'selected' : '' }}>-- Seleccione estado --</option>
            <option value="activo" {{ old('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    {{-- Fecha de Registro --}}
    <div style="margin-bottom: 2rem;">
        <label for="fecha_registro" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Fecha de Registro</label>
        <input
            type="datetime-local"
            name="fecha_registro"
            id="fecha_registro"
            value="{{ $fechaRegistro }}"
            aria-required="false"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
        >
    </div>

    {{-- Botón --}}
    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none; transition: background-color 0.3s ease;"
        onmouseover="this.style.backgroundColor='#1d4ed8'"
        onmouseout="this.style.backgroundColor='#2563eb'"
        aria-label="Guardar nuevo objetivo"
    >
        💾 Guardar Objetivo
    </button>

    <a href="{{ route('objetivos.index', ['tipo' => $tipo]) }}" style="margin-left: 1rem; color: #6b7280; font-weight: 600;">Cancelar</a>
</form>
@endsection
