@extends('layouts.app')

@section('content')
<h1>Dashboard Administrador</h1>
<p>Bienvenido {{ Auth::user()->name }}</p>
@endsection
