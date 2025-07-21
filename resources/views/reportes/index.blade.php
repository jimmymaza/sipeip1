@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 25px; color: #1e40af;">Generación de Reportes</h1>

  {{-- ✅ Mensaje de éxito si aplica --}}
  @if (session('success'))
    <div style="margin-bottom: 20px; background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 12px 18px; border-radius: 5px;">
      <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
      {{ session('success') }}
    </div>
  @endif

  <form id="formReportes" action="{{ route('reportes.generar') }}" method="GET" style="margin-bottom: 30px;">
    {{-- 🧩 Filtros --}}
    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
      
      <div style="flex: 1; min-width: 200px;">
        <label for="tipo" style="font-weight: bold;">Tipo de reporte:</label><br>
        <select name="tipo" id="tipo" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
          <option value="">Seleccione</option>
          <option value="usuarios" {{ request('tipo') == 'usuarios' ? 'selected' : '' }}>Usuarios</option>
          <option value="planes" {{ request('tipo') == 'planes' ? 'selected' : '' }}>Planes</option>
          <option value="objetivos_institucionales" {{ request('tipo') == 'objetivos_institucionales' ? 'selected' : '' }}>Objetivos Institucionales</option>
          <option value="proyectos" {{ request('tipo') == 'proyectos' ? 'selected' : '' }}>Proyectos</option>
        </select>
      </div>

      <div style="flex: 1; min-width: 200px;">
        <label for="institucion_id" style="font-weight: bold;">Institución:</label><br>
        <select name="institucion_id" id="institucion_id" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
          <option value="">-- Todas --</option>
          @foreach($instituciones as $institucion)
            <option value="{{ $institucion->IdInstitucion }}" {{ request('institucion_id') == $institucion->IdInstitucion ? 'selected' : '' }}>
              {{ $institucion->Nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div id="rol-container" style="flex: 1; min-width: 200px; display: none;">
        <label for="rol_id" style="font-weight: bold;">Rol:</label><br>
        <select name="rol_id" id="rol_id" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
          <option value="">-- Todos --</option>
          @foreach($roles as $rol)
            <option value="{{ $rol->IdRol }}" {{ request('rol_id') == $rol->IdRol ? 'selected' : '' }}>
              {{ $rol->Nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div style="flex: 1; min-width: 200px;">
        <label for="estado" style="font-weight: bold;">Estado:</label><br>
        <select name="estado" id="estado" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
          <option value="">-- Todos --</option>
          <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
          <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
      </div>
    </div>

    {{-- 📅 Fechas --}}
    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
      <div style="flex: 1; min-width: 200px;">
        <label for="fecha_desde" style="font-weight: bold;">Desde:</label><br>
        <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
          style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
      </div>

      <div style="flex: 1; min-width: 200px;">
        <label for="fecha_hasta" style="font-weight: bold;">Hasta:</label><br>
        <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
          style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
      </div>
    </div>

    {{-- 🧾 Botón Filtrar --}}
    <div style="margin-top: 20px;">
      <button type="submit" name="action" value="filtrar"
        style="background-color: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold;">
        <i class="fas fa-filter"></i> Filtrar
      </button>
    </div>
  </form>

  <a href="{{ url()->previous() }}"
     style="display: inline-block; margin-top: 30px; color: #2563eb; text-decoration: none; font-weight: bold;">
     ← Volver
  </a>

  {{-- Script para mostrar u ocultar campo Rol --}}
  <script>
    function toggleRolFilter() {
      const tipo = document.getElementById('tipo').value;
      const rolContainer = document.getElementById('rol-container');
      if (tipo === 'usuarios') {
        rolContainer.style.display = 'block';
      } else {
        rolContainer.style.display = 'none';
        document.getElementById('rol_id').value = '';
      }
    }

    document.getElementById('tipo').addEventListener('change', toggleRolFilter);
    window.addEventListener('DOMContentLoaded', toggleRolFilter);
  </script>
</div>
@endsection
