@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 30px 10px; font-family: Arial, sans-serif;">

  <h2 style="color: #1e40af; margin-bottom: 20px;">Editar Institución</h2>

  @if ($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>⚠️ {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('instituciones.update', $institucion->IdInstitucion) }}" method="POST" 
        style="background: #f9fafb; padding: 25px 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    @csrf
    @method('PUT')

    <label for="Nombre" style="font-weight: bold; display: block; margin-bottom: 6px;">Nombre</label>
    <input type="text" id="Nombre" name="Nombre" 
           value="{{ old('Nombre', $institucion->Nombre) }}" required 
           style="width: 100%; padding: 10px 12px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;">

    <label for="Codigo" style="font-weight: bold; display: block; margin-bottom: 6px;">Código</label>
    <input type="text" id="Codigo" name="Codigo" 
           value="{{ old('Codigo', $institucion->Codigo) }}" required 
           style="width: 100%; padding: 10px 12px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;">

    <label for="Subsector" style="font-weight: bold; display: block; margin-bottom: 6px;">Subsector</label>
    <select
        id="Subsector"
        name="Subsector"
        required
        style="width: 100%; padding: 10px 12px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"
    >
        <option value="" disabled {{ old('Subsector', $institucion->Subsector) ? '' : 'selected' }}>Seleccione un subsector</option>
        @foreach($subsectores as $subsector)
            <option value="{{ $subsector }}" 
                {{ (old('Subsector', $institucion->Subsector) == $subsector) ? 'selected' : '' }}>
                {{ $subsector }}
            </option>
        @endforeach
    </select>

    <label for="NivelGobierno" style="font-weight: bold; display: block; margin-bottom: 6px;">Nivel de Gobierno</label>
    <select id="NivelGobierno" name="NivelGobierno" required
            style="width: 100%; padding: 10px 12px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;">
      <option value="" disabled {{ old('NivelGobierno', $institucion->NivelGobierno) ? '' : 'selected' }}>Seleccione nivel</option>
      <option value="Nacional" {{ (old('NivelGobierno', $institucion->NivelGobierno) == 'Nacional') ? 'selected' : '' }}>Nacional</option>
      <option value="Provincial" {{ (old('NivelGobierno', $institucion->NivelGobierno) == 'Provincial') ? 'selected' : '' }}>Provincial</option>
      <option value="Cantonal" {{ (old('NivelGobierno', $institucion->NivelGobierno) == 'Cantonal') ? 'selected' : '' }}>Cantonal</option>
    </select>

    <label for="Estado" style="font-weight: bold; display: block; margin-bottom: 6px;">Estado</label>
    <select id="Estado" name="Estado" required
            style="width: 100%; padding: 10px 12px; margin-bottom: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;">
      <option value="" disabled {{ old('Estado', (string)$institucion->Estado) === '' ? 'selected' : '' }}>Seleccione estado</option>
      <option value="1" {{ old('Estado', (string)$institucion->Estado) === '1' ? 'selected' : '' }}>Activo</option>
      <option value="0" {{ old('Estado', (string)$institucion->Estado) === '0' ? 'selected' : '' }}>Inactivo</option>
    </select>

    <button type="submit" 
            style="background-color: #2563eb; color: white; padding: 12px 25px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; font-size: 1rem; transition: background-color 0.3s ease;">
      💾 Actualizar Institución
    </button>
  </form>
</div>
@endsection
