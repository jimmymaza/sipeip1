@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Meta</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('metas.update', $meta->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="codigo" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Código de la Meta</label>
        <input 
            type="text" 
            name="codigo" 
            id="codigo" 
            value="{{ old('codigo', $meta->codigo) }}" 
            required 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
            onfocus="this.style.borderColor='#2563eb'" 
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="nombre" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Nombre de la Meta</label>
        <input 
            type="text" 
            name="nombre" 
            id="nombre" 
            value="{{ old('nombre', $meta->nombre) }}" 
            required 
            autofocus
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
            onfocus="this.style.borderColor='#2563eb'" 
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="descripcion" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Descripción</label>
        <textarea 
            name="descripcion" 
            id="descripcion" 
            rows="4" 
            required 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; resize: vertical;"
            onfocus="this.style.borderColor='#2563eb'" 
            onblur="this.style.borderColor='#d1d5db'"
        >{{ old('descripcion', $meta->descripcion) }}</textarea>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="objetivo_id" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Objetivo Estratégico</label>
        <select 
            name="objetivo_id" 
            id="objetivo_id" 
            required 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
            onfocus="this.style.borderColor='#2563eb'" 
            onblur="this.style.borderColor='#d1d5db'"
        >
            @foreach ($objetivos as $objetivo)
                <option value="{{ $objetivo->id }}" {{ old('objetivo_id', $meta->objetivo_id) == $objetivo->id ? 'selected' : '' }}>
                    {{ $objetivo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="fecha_inicio" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Fecha de Inicio</label>
        <input 
            type="date" 
            name="fecha_inicio" 
            id="fecha_inicio" 
            value="{{ old('fecha_inicio', $meta->fecha_inicio ? $meta->fecha_inicio->format('Y-m-d') : '') }}" 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="fecha_fin" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Fecha de Fin</label>
        <input 
            type="date" 
            name="fecha_fin" 
            id="fecha_fin" 
            value="{{ old('fecha_fin', $meta->fecha_fin ? $meta->fecha_fin->format('Y-m-d') : '') }}" 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="estado" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Estado</label>
        <select 
            name="estado" 
            id="estado" 
            required 
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
            onfocus="this.style.borderColor='#2563eb'" 
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="activo" {{ old('estado', $meta->estado) === 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado', $meta->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button 
        type="submit" 
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
        onmouseover="this.style.backgroundColor='#1d4ed8'" 
        onmouseout="this.style.backgroundColor='#2563eb'"
    >
        💾 Actualizar Meta
    </button>
</form>
@endsection
