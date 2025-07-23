@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto 0 50px; font-family: 'Segoe UI', sans-serif;">

  <h2 style="color: #1e3a8a; margin-bottom: 25px;">Nuevo Cronograma</h2>

  @if ($errors->any())
    <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
      <strong>Se encontraron los siguientes errores:</strong>
      <ul style="padding-left: 20px; margin-top: 10px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('cronogramas.store') }}" 
        style="background: #f3f4f6; padding: 35px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    @csrf

    <div style="margin-bottom: 20px;">
      <label for="actividad" style="font-weight: bold; display: block;">Actividad</label>
      <input type="text" id="actividad" name="actividad" value="{{ old('actividad') }}" required
             style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    <div style="display: flex; gap: 20px;">
      <div style="flex: 1;">
        <label for="fecha_inicio" style="font-weight: bold; display: block;">Fecha Inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required
               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
      </div>

      <div style="flex: 1;">
        <label for="fecha_fin" style="font-weight: bold; display: block;">Fecha Fin</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required
               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
      </div>
    </div>

    <div style="margin-top: 20px;">
      <label for="responsable" style="font-weight: bold; display: block;">Responsable</label>
      <select id="responsable" name="responsable" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione un usuario --</option>
        @foreach ($usuarios as $usuario)
          <option value="{{ $usuario->IdUsuario }}" {{ old('responsable') == $usuario->IdUsuario ? 'selected' : '' }}>
            {{ $usuario->Nombre }} {{ $usuario->Apellido }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-top: 20px;">
      <label for="estado" style="font-weight: bold; display: block;">Estado</label>
      <select id="estado" name="estado" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="En progreso" {{ old('estado') == 'En progreso' ? 'selected' : '' }}>En progreso</option>
        <option value="Completado" {{ old('estado') == 'Completado' ? 'selected' : '' }}>Completado</option>
      </select>
    </div>

    <div style="margin-top: 20px;">
      <label for="plan_id" style="font-weight: bold; display: block;">Plan</label>
      <select id="plan_id" name="plan_id" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione --</option>
        @foreach($planes as $plan)
          <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
            {{ $plan->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-top: 20px;">
      <label for="programa_id" style="font-weight: bold; display: block;">Programa</label>
      <select id="programa_id" name="programa_id" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione --</option>
        @foreach($programas as $programa)
          <option value="{{ $programa->id }}" {{ old('programa_id') == $programa->id ? 'selected' : '' }}>
            {{ $programa->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-top: 20px;">
      <label for="proyecto_id" style="font-weight: bold; display: block;">Proyecto</label>
      <select id="proyecto_id" name="proyecto_id" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione --</option>
        @foreach($proyectos as $proyecto)
          <option value="{{ $proyecto->id }}" {{ old('proyecto_id') == $proyecto->id ? 'selected' : '' }}>
            {{ $proyecto->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-top: 30px; display: flex; gap: 15px;">
      <a href="{{ route('cronogramas.index') }}"
         style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
        Cancelar
      </a>

      <button type="submit"
              style="background-color: #2563eb; color: white; padding: 10px 25px; border-radius: 6px; border: none; font-weight: 600;">
        Guardar Cronograma
      </button>
    </div>
  </form>
</div>
@endsection
