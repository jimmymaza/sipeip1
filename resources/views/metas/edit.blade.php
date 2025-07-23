@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Editar Meta</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('metas.update', $meta->id) }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 700px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="descripcion" style="font-weight: 700; color: #374151;">Descripción</label>
        <input
            type="text"
            id="descripcion"
            name="descripcion"
            value="{{ old('descripcion', $meta->descripcion) }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
            placeholder="Ingrese la descripción de la meta"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="usuario_responsable_id" style="font-weight: 700; color: #374151;">Responsable</label>
        <select
            name="usuario_responsable_id"
            id="usuario_responsable_id"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled>Seleccione un responsable</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ old('usuario_responsable_id', $meta->usuario_responsable_id) == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
    >
        💾 Actualizar Meta
    </button>
</form>
@endsection
