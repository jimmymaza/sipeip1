@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto 0 50px; font-family: 'Segoe UI', sans-serif;">

  <h2 style="color: #1e3a8a; margin-bottom: 25px;">Crear Nueva Vinculación</h2>

  @if ($errors->any())
      <div style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; border: 2px solid #f87171;">
          <ul style="list-style: disc inside;">
              @foreach ($errors->all() as $error)
                  <li>⚠️ {{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <form action="{{ route('vinculaciones.store') }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
      @csrf

      <div style="margin-bottom: 1.5rem;">
          <label for="objetivo_institucional_id" style="font-weight: 700; color: #374151;">Objetivo Institucional:</label>
          <select name="objetivo_institucional_id" id="objetivo_institucional_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione un objetivo --</option>
              @foreach($objetivos as $objetivo)
                  <option value="{{ $objetivo->id }}" {{ old('objetivo_institucional_id') == $objetivo->id ? 'selected' : '' }}>
                      {{ $objetivo->nombre }}
                  </option>
              @endforeach
          </select>
          @error('objetivo_institucional_id')
              <p style="color: #dc2626; margin-top: 0.5rem;">{{ $message }}</p>
          @enderror
      </div>

      <div style="margin-bottom: 1.5rem;">
          <label for="meta_id" style="font-weight: 700; color: #374151;">Meta:</label>
          <select name="meta_id" id="meta_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione una meta --</option>
              @foreach($metas as $meta)
                  <option value="{{ $meta->id }}" data-objetivo="{{ $meta->objetivo_institucional_id }}" {{ old('meta_id') == $meta->id ? 'selected' : '' }}>
                      {{ $meta->nombre }}
                  </option>
              @endforeach
          </select>
          @error('meta_id')
              <p style="color: #dc2626; margin-top: 0.5rem;">{{ $message }}</p>
          @enderror
      </div>

      <div style="margin-bottom: 1.5rem;">
          <label for="indicador_id" style="font-weight: 700; color: #374151;">Indicador:</label>
          <select name="indicador_id" id="indicador_id" required
              style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem;">
              <option value="">-- Seleccione un indicador --</option>
              @foreach($indicadores as $indicador)
                  <option value="{{ $indicador->id }}" data-objetivo="{{ $indicador->objetivo_institucional_id }}" {{ old('indicador_id') == $indicador->id ? 'selected' : '' }}>
                      {{ $indicador->nombre }}
                  </option>
              @endforeach
          </select>
          @error('indicador_id')
              <p style="color: #dc2626; margin-top: 0.5rem;">{{ $message }}</p>
          @enderror
      </div>

      <div style="margin-top: 2rem;">
          <button type="submit"
              style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;">
              💾 Guardar
          </button>
          <a href="{{ route('vinculaciones.index') }}"
              style="margin-left: 1rem; color: #374151; font-weight: 600; text-decoration: underline;">
              Cancelar
          </a>
      </div>
  </form>
</div>

<script>
  // Filtrar metas e indicadores según el objetivo seleccionado
  document.getElementById('objetivo_institucional_id').addEventListener('change', function() {
    const objetivoId = this.value;
    
    const metaSelect = document.getElementById('meta_id');
    const indicadorSelect = document.getElementById('indicador_id');

    // Mostrar/Ocultar metas
    Array.from(metaSelect.options).forEach(option => {
      if (!option.value) return; // opción placeholder
      option.style.display = option.dataset.objetivo === objetivoId ? 'block' : 'none';
      if(option.dataset.objetivo !== objetivoId){
        option.selected = false;
      }
    });

    // Mostrar/Ocultar indicadores
    Array.from(indicadorSelect.options).forEach(option => {
      if (!option.value) return; // opción placeholder
      option.style.display = option.dataset.objetivo === objetivoId ? 'block' : 'none';
      if(option.dataset.objetivo !== objetivoId){
        option.selected = false;
      }
    });
  });

  // Disparar evento para filtrar al cargar la página (por si hay valor viejo)
  document.getElementById('objetivo_institucional_id').dispatchEvent(new Event('change'));
</script>
@endsection
