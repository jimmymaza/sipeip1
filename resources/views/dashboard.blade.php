@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 30px;">
    <h1 style="font-size: 1.8rem; margin-bottom: 10px;">Bienvenido, {{ Auth::user()->name }}</h1>
    <p style="margin-bottom: 30px;">Rol: <strong>{{ ucfirst(Auth::user()->rol) }}</strong></p>
</div>
@endsection
