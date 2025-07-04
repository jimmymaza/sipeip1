@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Editar Rol</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.update', $rol->idRol) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Nombre del Rol</label>
            <input type="text" name="nombreRol" required value="{{ old('nombreRol', $rol->nombreRol) }}">
        </div>

        <div>
            <label class="block">Descripción</label>
            <textarea name="descripcion" required>{{ old('descripcion', $rol->descripcion) }}</textarea>
        </div>

        <button type="submit">Actualizar</button>
        <a href="{{ route('roles.index') }}">Volver</a>
    </form>
@endsection
