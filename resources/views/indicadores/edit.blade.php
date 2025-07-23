@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Editar Indicador</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('indicadores.update', $indicador->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="descripcion" class="block font-medium mb-1">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $indicador->descripcion) }}" class="w-full border border-gray-300 p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="id_usuario_responsable" class="block font-medium mb-1">Responsable</label>
            <select name="id_usuario_responsable" id="id_usuario_responsable" class="w-full border border-gray-300 p-2 rounded" required>
                <option value="">-- Seleccionar Usuario --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->IdUsuario }}" {{ (old('id_usuario_responsable', $indicador->id_usuario_responsable) == $usuario->IdUsuario) ? 'selected' : '' }}>
                        {{ $usuario->Nombre }} {{ $usuario->Apellido }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('indicadores.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection
