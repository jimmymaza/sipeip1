@extends('layouts.app')

@section('content')
<h2 style="color: #1e40af; margin-bottom: 1.5rem; font-weight: 700;">Crear Institución</h2>

@if ($errors->any())
    <div role="alert" style="background-color: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 1.5rem; border: 2px solid #f87171;">
        <ul style="list-style: disc inside;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('instituciones.store') }}" method="POST" style="background-color: #f9fafb; padding: 2rem; border-radius: 10px; max-width: 700px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
    @csrf

    <div style="margin-bottom: 1.5rem;">
        <label for="Nombre" style="font-weight: 700; color: #374151;">Nombre</label>
        <input
            type="text"
            name="Nombre"
            id="Nombre"
            value="{{ old('Nombre') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Codigo" style="font-weight: 700; color: #374151;">Código</label>
        <input
            type="text"
            name="Codigo"
            id="Codigo"
            value="{{ old('Codigo') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="Subsector" style="font-weight: 700; color: #374151;">Subsector</label>
        <input
            type="text"
            name="Subsector"
            id="Subsector"
            value="{{ old('Subsector') }}"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="NivelGobierno" style="font-weight: 700; color: #374151;">Nivel de Gobierno</label>
        <select
            name="NivelGobierno"
            id="NivelGobierno"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled selected>Seleccione un nivel</option>
            <option value="Nacional" {{ old('NivelGobierno') == 'Nacional' ? 'selected' : '' }}>Nacional</option>
            <option value="Provincial" {{ old('NivelGobierno') == 'Provincial' ? 'selected' : '' }}>Provincial</option>
            <option value="Cantonal" {{ old('NivelGobierno') == 'Cantonal' ? 'selected' : '' }}>Cantonal</option>
        </select>
    </div>

    <div style="margin-bottom: 2rem;">
        <label for="Estado" style="font-weight: 700; color: #374151;">Estado</label>
        <select
            name="Estado"
            id="Estado"
            required
            style="width: 100%; padding: 0.6rem 0.8rem; border: 1.8px solid #d1d5db; border-radius: 8px;"
        >
            <option value="" disabled selected>Seleccione un estado</option>
            <option value="Activo" {{ old('Estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ old('Estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button
        type="submit"
        style="background-color: #2563eb; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;"
    >
        💾 Crear Institución
    </button>
</form>
@endsection
