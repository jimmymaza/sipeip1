@extends('layouts.app')

@section('content')
<h1>Roles</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($roles as $rol)
        <tr>
            <td>{{ $rol->id }}</td>
            <td>{{ $rol->nombre }}</td>
            <td>{{ $rol->descripcion }}</td>
        </tr>
        @empty
        <tr><td colspan="3">No hay roles.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
