@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">

  <h1 style="margin-bottom: 20px; color: #1e40af; font-weight: 700;">Editar Meta</h1>

  @if ($errors->any())
    <div style="margin-bottom: 20px; background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 12px 18px; border-radius: 5px;">
      <strong style="font-weight: 700;">Por favor corrige los siguientes errores:</strong>
      <ul style="margin-top: 10px; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('metas.update', $meta->id) }}" method="POST" style="max-width: 600px;">
    @csrf
    @method('PUT')

    {{-- Objetivo --}}
    <div style="margin-bottom: 16px;">
      <label for="objetivo_id" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Objetivo</label>
      <select name="objetivo_id" id="objetivo_id" required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background: white;">
        <option value="" disabled {{ old('objetivo_id', $meta->objetivo_id) ? '' : 'selected' }}>-- Seleccionar Objetivo --</option>
        @foreach ($objetivos as $objetivo)
          <option value="{{ $objetivo->id }}" {{ old('objetivo_id', $meta->objetivo_id) == $objetivo->id ? 'selected' : '' }}>
            {{ $objetivo->nombre ?? $objetivo->descripcion }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Plan --}}
    <div style="margin-bottom: 16px;">
      <label for="plan_id" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Plan</label>
      <select name="plan_id" id="plan_id" required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background: white;">
        <option value="" disabled {{ old('plan_id', $meta->plan_id) ? '' : 'selected' }}>-- Seleccionar Plan --</option>
        @foreach ($planes as $plan)
          <option value="{{ $plan->id }}" {{ old('plan_id', $meta->plan_id) == $plan->id ? 'selected' : '' }}>
            {{ $plan->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Indicador --}}
    <div style="margin-bottom: 16px;">
      <label for="id_indicador" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Indicador</label>
      <select name="id_indicador" id="id_indicador" required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background: white;">
        <option value="" disabled {{ old('id_indicador', $meta->id_indicador) ? '' : 'selected' }}>-- Seleccionar Indicador --</option>
        @foreach ($indicadores as $indicador)
          <option value="{{ $indicador->id }}" {{ old('id_indicador', $meta->id_indicador) == $indicador->id ? 'selected' : '' }}>
            {{ $indicador->codigo }} - {{ $indicador->descripcion }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Año --}}
    <div style="margin-bottom: 16px;">
      <label for="anio" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Año</label>
      <input
        type="number" name="anio" id="anio"
        min="2000" max="2100"
        value="{{ old('anio', $meta->anio) }}"
        placeholder="Ej: 2025"
        required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"
      >
    </div>

    {{-- Valor Objetivo --}}
    <div style="margin-bottom: 16px;">
      <label for="valor_objetivo" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Valor Objetivo</label>
      <input
        type="number" step="0.01" name="valor_objetivo" id="valor_objetivo"
        value="{{ old('valor_objetivo', $meta->valor_objetivo) }}"
        placeholder="Ej: 85.50"
        required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"
      >
    </div>

    {{-- Estado --}}
    <div style="margin-bottom: 16px;">
      <label for="estado" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Estado</label>
      <select name="estado" id="estado" required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background: white;">
        <option value="" disabled {{ old('estado', $meta->estado) ? '' : 'selected' }}>-- Seleccionar Estado --</option>
        <option value="activo" {{ old('estado', strtolower($meta->estado)) == 'activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ old('estado', strtolower($meta->estado)) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    {{-- Responsable --}}
    <div style="margin-bottom: 16px;">
      <label for="usuario_responsable_id" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Responsable</label>
      <select name="usuario_responsable_id" id="usuario_responsable_id" required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background: white;">
        <option value="" disabled {{ old('usuario_responsable_id', $meta->usuario_responsable_id) ? '' : 'selected' }}>-- Seleccionar Usuario --</option>
        @foreach ($usuarios as $usuario)
          <option value="{{ $usuario->IdUsuario }}" {{ old('usuario_responsable_id', $meta->usuario_responsable_id) == $usuario->IdUsuario ? 'selected' : '' }}>
            {{ $usuario->Nombre }} {{ $usuario->Apellido }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Fecha de Registro --}}
    <div style="margin-bottom: 24px;">
      <label for="fecha_registro" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Fecha de Registro</label>
      <input
        type="date" name="fecha_registro" id="fecha_registro"
        value="{{ old('fecha_registro', $meta->fecha_registro ? \Carbon\Carbon::parse($meta->fecha_registro)->format('Y-m-d') : '') }}"
        required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"
      >
    </div>

    <div style="display: flex; justify-content: flex-end;">
      <a href="{{ route('metas.index') }}" 
        style="background-color: #6b7280; color: white; font-weight: 700; padding: 12px 22px; border-radius: 5px; text-decoration: none; margin-right: 12px;">
        Cancelar
      </a>
      <button type="submit"
        style="background-color: #2563eb; color: white; font-weight: 700; padding: 12px 22px; border-radius: 5px; border: none; cursor: pointer;"
        onmouseover="this.style.backgroundColor='#1e40af'"
        onmouseout="this.style.backgroundColor='#2563eb'">
        Actualizar Meta
      </button>
    </div>

  </form>
</div>
@endsection
