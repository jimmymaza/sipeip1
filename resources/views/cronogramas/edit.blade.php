@extends('layouts.app')

@section('content')
<h2 style="color: #1e3a8a; font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">Editar Cronograma</h2>

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

<form action="{{ route('cronogramas.update', $cronograma->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 1rem; max-width: 700px; box-shadow: 0 8px 20px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    {{-- Actividad --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="actividad" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Actividad</label>
        <input type="text" name="actividad" id="actividad" value="{{ old('actividad', $cronograma->actividad) }}" required 
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
    </div>

    {{-- Fechas --}}
    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
        <div style="flex: 1;">
            <label for="fecha_inicio" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $cronograma->fecha_inicio) }}" required 
                style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
        </div>

        <div style="flex: 1;">
            <label for="fecha_fin" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $cronograma->fecha_fin) }}" required 
                style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
        </div>
    </div>

    {{-- Responsable --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="responsable" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Responsable</label>
        <select name="responsable" id="responsable" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
            <option value="">-- Seleccione un usuario --</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->IdUsuario }}" {{ old('responsable', $cronograma->responsable) == $usuario->IdUsuario ? 'selected' : '' }}>
                    {{ $usuario->Nombre }} {{ $usuario->Apellido }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Estado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="estado" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Estado</label>
        <select name="estado" id="estado" required
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
            <option value="Pendiente" {{ old('estado', $cronograma->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="En progreso" {{ old('estado', $cronograma->estado) == 'En progreso' ? 'selected' : '' }}>En progreso</option>
            <option value="Completado" {{ old('estado', $cronograma->estado) == 'Completado' ? 'selected' : '' }}>Completado</option>
        </select>
    </div>

    {{-- Observaciones --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="observaciones" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Observaciones</label>
        <textarea name="observaciones" id="observaciones" rows="4"
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem; resize: vertical;">{{ old('observaciones', $cronograma->observaciones) }}</textarea>
    </div>

    {{-- Plan --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="plan_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Plan</label>
        <select name="plan_id" id="plan_id" required 
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
            <option value="">-- Seleccione --</option>
            @foreach($planes as $plan)
                <option value="{{ $plan->id }}" {{ old('plan_id', $cronograma->plan_id) == $plan->id ? 'selected' : '' }}>
                    {{ $plan->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Programa --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="programa_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Programa</label>
        <select name="programa_id" id="programa_id" required 
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
            <option value="">-- Seleccione --</option>
            @foreach($programas as $programa)
                <option value="{{ $programa->id }}" {{ old('programa_id', $cronograma->programa_id) == $programa->id ? 'selected' : '' }}>
                    {{ $programa->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Proyecto --}}
    <div style="margin-bottom: 2rem;">
        <label for="proyecto_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Proyecto</label>
        <select name="proyecto_id" id="proyecto_id" required 
            style="width: 100%; padding: 0.75rem 1rem; border: 1.8px solid #cbd5e1; border-radius: 0.75rem; font-size: 1rem;">
            <option value="">-- Seleccione --</option>
            @foreach($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $cronograma->proyecto_id) == $proyecto->id ? 'selected' : '' }}>
                    {{ $proyecto->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Botones --}}
    <div style="display: flex; gap: 1rem;">
        <button type="submit" 
            style="background-color: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'">
            Actualizar Cronograma
        </button>

        <a href="{{ route('cronogramas.index') }}" 
            style="background-color: #e5e7eb; color: #1f2937; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; font-size: 1rem; text-decoration: none;">
            Cancelar
        </a>
    </div>
</form>
@endsection
