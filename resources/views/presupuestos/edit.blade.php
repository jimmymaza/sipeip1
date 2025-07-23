@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Presupuesto</h2>

{{-- Mensaje de éxito --}}
@if(session('success'))
    <div role="alert" style="background-color: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #10b981;">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Errores de validación --}}
@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside; margin: 0; padding-left: 1rem;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    {{-- Plan asociado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="plan_id" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Plan Asociado</label>
        <select
            name="plan_id"
            id="plan_id"
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="">-- Seleccione un plan --</option>
            @foreach ($planes as $plan)
                <option value="{{ $plan->id }}" {{ (old('plan_id', $presupuesto->plan_id) == $plan->id) ? 'selected' : '' }}>
                    {{ $plan->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Programa asociado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="programa_id" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Programa Asociado</label>
        <select
            name="programa_id"
            id="programa_id"
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="">-- Seleccione un programa --</option>
            @foreach ($programas as $programa)
                <option value="{{ $programa->id }}" {{ (old('programa_id', $presupuesto->programa_id) == $programa->id) ? 'selected' : '' }}>
                    {{ $programa->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Proyecto asociado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="proyecto_id" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Proyecto Asociado</label>
        <select
            name="proyecto_id"
            id="proyecto_id"
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="">-- Seleccione un proyecto --</option>
            @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ (old('proyecto_id', $presupuesto->proyecto_id) == $proyecto->id) ? 'selected' : '' }}>
                    {{ $proyecto->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Monto --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="monto" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Monto</label>
        <input 
            type="number" 
            name="monto" 
            id="monto" 
            value="{{ old('monto', $presupuesto->monto) }}" 
            required
            step="0.01"
            min="0"
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    {{-- Fuente de Financiamiento --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="fuente_financiamiento" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Fuente de Financiamiento</label>
        <input 
            type="text" 
            name="fuente_financiamiento" 
            id="fuente_financiamiento" 
            value="{{ old('fuente_financiamiento', $presupuesto->fuente_financiamiento) }}" 
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    {{-- Descripción --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="descripcion" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Descripción</label>
        <textarea 
            name="descripcion" 
            id="descripcion" 
            rows="4"
            aria-required="false"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; resize: vertical;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >{{ old('descripcion', $presupuesto->descripcion) }}</textarea>
    </div>

    {{-- Año --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="anio" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Año</label>
        <input 
            type="number" 
            name="anio" 
            id="anio" 
            value="{{ old('anio', $presupuesto->anio) }}" 
            required
            min="1900"
            max="2099"
            step="1"
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
    </div>

    {{-- Estado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="estado" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">Estado</label>
        <select 
            name="estado" 
            id="estado" 
            required
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="activo" {{ old('estado', $presupuesto->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado', $presupuesto->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    {{-- Botón --}}
    <button 
        type="submit" 
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none; transition: background-color 0.3s ease;"
        onmouseover="this.style.backgroundColor='#1d4ed8'"
        onmouseout="this.style.backgroundColor='#2563eb'"
        aria-label="Actualizar presupuesto"
    >
        💾 Actualizar Presupuesto
    </button>
</form>
@endsection
