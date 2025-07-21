@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">
  Editar Alineación para: <strong>{{ $objetivo->nombre }}</strong>
</h2>

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

<form action="{{ route('objetivos.alineaciones.update', ['tipo' => $tipo, 'objetivo' => $objetivo->id, 'alineacion' => $alineacion->id]) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    {{-- Seleccionar objetivo alineado --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="objetivo_alineado_id" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">
          Objetivo Alineado
        </label>
        <select 
            name="objetivo_alineado_id" 
            id="objetivo_alineado_id" 
            required 
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="" disabled>-- Seleccione un objetivo --</option>
            @foreach($objetivosPosibles as $obj)
              <option value="{{ $obj->id }}" {{ old('objetivo_alineado_id', $alineacion->objetivo_alineado_id) == $obj->id ? 'selected' : '' }}>
                [{{ $obj->codigo }}] {{ $obj->nombre }} ({{ ucfirst($obj->tipo) }})
              </option>
            @endforeach
        </select>
    </div>

    {{-- Tipo de alineación --}}
    <div style="margin-bottom: 1.5rem;">
        <label for="tipo_alineacion" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #374151;">
          Tipo de Alineación
        </label>
        <select 
            name="tipo_alineacion" 
            id="tipo_alineacion" 
            required 
            aria-required="true"
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;"
            onfocus="this.style.borderColor='#2563eb'"
            onblur="this.style.borderColor='#d1d5db'"
        >
            <option value="" disabled>-- Seleccione tipo de alineación --</option>
            <option value="institucional-pnd" {{ old('tipo_alineacion', $alineacion->tipo_alineacion) == 'institucional-pnd' ? 'selected' : '' }}>
              Institucional - PND
            </option>
            <option value="pnd-ods" {{ old('tipo_alineacion', $alineacion->tipo_alineacion) == 'pnd-ods' ? 'selected' : '' }}>
              PND - ODS
            </option>
            <option value="institucional-ods" {{ old('tipo_alineacion', $alineacion->tipo_alineacion) == 'institucional-ods' ? 'selected' : '' }}>
              Institucional - ODS
            </option>
            {{-- Puedes agregar más tipos aquí si tienes --}}
        </select>
    </div>

    {{-- Botón --}}
    <button 
        type="submit" 
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none; transition: background-color 0.3s ease;"
        onmouseover="this.style.backgroundColor='#1d4ed8'"
        onmouseout="this.style.backgroundColor='#2563eb'"
        aria-label="Actualizar alineación"
    >
        💾 Actualizar Alineación
    </button>
</form>
@endsection
