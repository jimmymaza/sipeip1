@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Vinculación</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('vinculaciones.update', $vinculacion->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 700px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="objetivo_institucional_id" style="font-weight: 700; color: #374151;">Objetivo Institucional</label>
        <select
            name="objetivo_institucional_id"
            id="objetivo_institucional_id"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione un objetivo institucional</option>
            @foreach($objetivos as $objetivo)
                <option value="{{ $objetivo->id }}" {{ $vinculacion->objetivo_institucional_id == $objetivo->id ? 'selected' : '' }}>
                    {{ $objetivo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="meta_id" style="font-weight: 700; color: #374151;">Meta</label>
        <select
            name="meta_id"
            id="meta_id"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione una meta</option>
            @foreach($metas as $meta)
                <option value="{{ $meta->id }}" {{ $vinculacion->meta_id == $meta->id ? 'selected' : '' }}>
                    {{ $meta->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="indicador_id" style="font-weight: 700; color: #374151;">Indicador</label>
        <select
            name="indicador_id"
            id="indicador_id"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione un indicador</option>
            @foreach($indicadores as $indicador)
                <option value="{{ $indicador->id }}" {{ $vinculacion->indicador_id == $indicador->id ? 'selected' : '' }}>
                    {{ $indicador->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
    >
        💾 Actualizar Vinculación
    </button>
</form>
@endsection
