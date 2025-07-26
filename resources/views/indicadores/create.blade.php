@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto 0 50px; font-family: 'Segoe UI', sans-serif;">

  <h2 style="color: #1e3a8a; margin-bottom: 25px;">Nuevo Indicador</h2>

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

  <form method="POST" action="{{ route('indicadores.store') }}" 
        style="background: #f3f4f6; padding: 35px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    @csrf

    {{-- id_alineacion --}}
    <div style="margin-bottom: 20px;">
      <label for="id_alineacion" style="font-weight: bold; display: block;">Alineación</label>
      <select id="id_alineacion" name="id_alineacion" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione una alineación --</option>
        @foreach ($vinculaciones as $vinculacion)
          <option value="{{ $vinculacion->id }}" {{ old('id_alineacion') == $vinculacion->id ? 'selected' : '' }}>
            {{ $vinculacion->nombre ?? $vinculacion->descripcion ?? $vinculacion->id }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-bottom: 20px;">
      <label for="codigo" style="font-weight: bold; display: block;">Código</label>
      <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}" required placeholder="Ej: IND001"
             style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    <div style="margin-bottom: 20px;">
      <label for="nombre" style="font-weight: bold; display: block;">Nombre</label>
      <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Nombre del indicador"
             style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    <div style="margin-bottom: 20px;">
      <label for="descripcion" style="font-weight: bold; display: block;">Descripción</label>
      <textarea id="descripcion" name="descripcion" 
                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" rows="4" placeholder="Descripción opcional">{{ old('descripcion') }}</textarea>
    </div>

    <div style="margin-bottom: 20px;">
      <label for="unidad_medida" style="font-weight: bold; display: block;">Unidad de Medida</label>
      <input type="text" id="unidad_medida" name="unidad_medida" value="{{ old('unidad_medida') }}" required placeholder="Ej: Porcentaje, Número, Meses"
             style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    {{-- Campo Responsable oculto --}}

    <div style="margin-bottom: 20px;">
      <label for="estado" style="font-weight: bold; display: block;">Estado</label>
      <select id="estado" name="estado" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
        <option value="">-- Seleccione un estado --</option>
        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    <div style="margin-bottom: 20px;">
      <label for="fecha_registro" style="font-weight: bold; display: block;">Fecha de Registro</label>
      <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro') ?? date('Y-m-d') }}" required
             style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    <div style="margin-top: 30px; display: flex; gap: 15px;">
      <a href="{{ route('indicadores.index') }}"
         style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
        Cancelar
      </a>

      <button type="submit"
              style="background-color: #2563eb; color: white; padding: 10px 25px; border-radius: 6px; border: none; font-weight: 600;">
        Guardar Indicador
      </button>
    </div>
  </form>
</div>
@endsection
