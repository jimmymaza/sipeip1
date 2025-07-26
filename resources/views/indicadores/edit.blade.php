@extends('layouts.app')

@section('content')
<h2 style="color: #1e3a8a; font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">Editar Indicador</h2>

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 2px solid #10b981;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('indicadores.update', $indicador->id) }}" method="POST"
    style="background-color: #f9fafb; padding: 2rem; border-radius: 1rem; max-width: 700px; box-shadow: 0 8px 20px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    {{-- Vinculación --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="id_alineacion" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Vinculación</label>
        <select name="id_alineacion" id="id_alineacion" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
            <option value="">-- Seleccione una vinculación --</option>
            @foreach($vinculaciones as $vinculacion)
                <option value="{{ $vinculacion->id }}" {{ old('id_alineacion', $indicador->id_alineacion) == $vinculacion->id ? 'selected' : '' }}>
                    {{ $vinculacion->nombre ?? 'Vinculación ' . $vinculacion->id }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Código --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="codigo" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Código</label>
        <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $indicador->codigo) }}" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
    </div>

    {{-- Nombre --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="nombre" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $indicador->nombre) }}" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
    </div>

    {{-- Descripción --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="descripcion" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">{{ old('descripcion', $indicador->descripcion) }}</textarea>
    </div>

    {{-- Unidad de Medida --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="unidad_medida" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Unidad de Medida</label>
        <input type="text" name="unidad_medida" id="unidad_medida" value="{{ old('unidad_medida', $indicador->unidad_medida) }}" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
    </div>

    {{-- Estado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="estado" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Estado</label>
        <select name="estado" id="estado" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
            <option value="activo" {{ old('estado', $indicador->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado', $indicador->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    {{-- Fecha de Registro --}}
    <div style="margin-bottom: 2rem;">
        <label for="fecha_registro" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Fecha de Registro</label>
        <input type="date" name="fecha_registro" id="fecha_registro"
            value="{{ old('fecha_registro', $indicador->fecha_registro ? $indicador->fecha_registro->format('Y-m-d') : '') }}"
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem;">
    </div>

    {{-- Botones --}}
    <div style="display: flex; gap: 1rem;">
        <button type="submit"
            style="background-color: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'">
            Actualizar Indicador
        </button>

        <a href="{{ route('indicadores.index') }}"
            style="background-color: #e5e7eb; color: #1f2937; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; font-size: 1rem; text-decoration: none;">
            Cancelar
        </a>
    </div>
</form>
@endsection
