@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto 0 50px; font-family: 'Segoe UI', sans-serif;">

  <h2 style="color: #1e3a8a; margin-bottom: 25px;">Editar Vinculación</h2>

  @if ($errors->any())
      <div style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; border: 2px solid #f87171;">
          <ul style="list-style: disc inside; margin: 0; padding-left: 20px;">
              @foreach ($errors->all() as $error)
                  <li>⚠️ {{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <form action="{{ route('vinculaciones.update', $vinculacion->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
      @csrf
      @method('PUT')

      {{-- Tipo --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="tipo" style="font-weight: 700; color: #374151;">Tipo:</label>
          <select name="tipo" id="tipo" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione un tipo --</option>
              <option value="PLAN NACIONAL" {{ old('tipo', $vinculacion->tipo) == 'PLAN NACIONAL' ? 'selected' : '' }}>Plan Nacional</option>
              <option value="ODS" {{ old('tipo', $vinculacion->tipo) == 'ODS' ? 'selected' : '' }}>ODS</option>
              <option value="INSTITUCIONAL" {{ old('tipo', $vinculacion->tipo) == 'INSTITUCIONAL' ? 'selected' : '' }}>Institucional</option>
          </select>
      </div>

      {{-- Nombre --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="nombre" style="font-weight: 700; color: #374151;">Nombre:</label>
          <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $vinculacion->nombre) }}" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
      </div>

      {{-- Descripción --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="descripcion" style="font-weight: 700; color: #374151;">Descripción:</label>
          <textarea name="descripcion" id="descripcion" rows="4" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">{{ old('descripcion', $vinculacion->descripcion) }}</textarea>
      </div>

      {{-- Objetivo Institucional --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="objetivo_institucional_id" style="font-weight: 700; color: #374151;">Objetivo Institucional:</label>
          <select name="objetivo_institucional_id" id="objetivo_institucional_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione un objetivo --</option>
              @foreach($objetivos as $objetivo)
                  <option value="{{ $objetivo->id }}" {{ old('objetivo_institucional_id', $vinculacion->objetivo_institucional_id) == $objetivo->id ? 'selected' : '' }}>
                      {{ $objetivo->nombre }}
                  </option>
              @endforeach
          </select>
      </div>

      {{-- Indicador --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="indicador_id" style="font-weight: 700; color: #374151;">Indicador:</label>
          <select name="indicador_id" id="indicador_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione un indicador --</option>
              @foreach($indicadores as $indicador)
                  <option value="{{ $indicador->id }}" data-objetivo="{{ $indicador->id_alineacion }}" 
                    {{ old('indicador_id', $vinculacion->indicador_id) == $indicador->id ? 'selected' : '' }}>
                    {{ $indicador->nombre }}
                  </option>
              @endforeach
          </select>
      </div>

      {{-- Meta --}}
      <div style="margin-bottom: 1.5rem;">
          <label for="meta_id" style="font-weight: 700; color: #374151;">Meta:</label>
          <select name="meta_id" id="meta_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione una meta --</option>
              @foreach($metas as $meta)
                  <option value="{{ $meta->id }}" data-indicador="{{ $meta->id_indicador }}" 
                    {{ old('meta_id', $vinculacion->meta_id) == $meta->id ? 'selected' : '' }}>
                    {{ $meta->anio }} - {{ $meta->valor_objetivo }}
                  </option>
              @endforeach
          </select>
      </div>

      <div style="margin-top: 2rem;">
          <button type="submit"
              style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;">
              💾 Guardar Cambios
          </button>
          <a href="{{ route('vinculaciones.index') }}"
              style="margin-left: 1rem; color: #374151; font-weight: 600; text-decoration: underline;">
              Cancelar
          </a>
      </div>
  </form>
</div>

<script>
  const objetivoSelect = document.getElementById('objetivo_institucional_id');
  const indicadorSelect = document.getElementById('indicador_id');
  const metaSelect = document.getElementById('meta_id');

  function filtrarIndicadores() {
    const objetivoId = objetivoSelect.value;
    Array.from(indicadorSelect.options).forEach(option => {
      if (!option.value) return;
      if (!objetivoId) {
        option.disabled = false;
        option.style.color = '';
      } else if (option.dataset.objetivo !== objetivoId && option.value !== indicadorSelect.value) {
        option.disabled = true;
        option.style.color = '#999999';
      } else {
        option.disabled = false;
        option.style.color = '';
      }
    });
  }

  function filtrarMetas() {
    const indicadorId = indicadorSelect.value;
    Array.from(metaSelect.options).forEach(option => {
      if (!option.value) return;
      if (!indicadorId) {
        option.disabled = false;
        option.style.color = '';
      } else if (option.dataset.indicador !== indicadorId && option.value !== metaSelect.value) {
        option.disabled = true;
        option.style.color = '#999999';
      } else {
        option.disabled = false;
        option.style.color = '';
      }
    });
  }

  objetivoSelect.addEventListener('change', () => {
    filtrarIndicadores();
    filtrarMetas();
  });

  indicadorSelect.addEventListener('change', filtrarMetas);

  filtrarIndicadores();
  filtrarMetas();
</script>
@endsection
