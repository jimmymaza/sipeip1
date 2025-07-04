@extends('layouts.app')

@section('title', 'Nuevo Rol')

@section('content')
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block">Nombre del Rol</label>
            <input type="text" name="nombreRol" required value="{{ old('nombreRol') }}">
        </div>

        <div>
            <label class="block">Descripción</label>
            <textarea name="descripcion" required>{{ old('descripcion') }}</textarea>
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('roles.index') }}">Volver</a>
    </form>
@endsection
