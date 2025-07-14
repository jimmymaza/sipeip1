{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.app')

@section('content')
    <h2 class="text-center text-2xl font-bold mb-6 text-indigo-700">Recuperar Contraseña</h2>

    @if (session('status'))
        <div role="alert" class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div role="alert" class="mb-4 font-medium text-sm text-red-600 bg-red-100 p-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <label for="email" class="sr-only">Correo Electrónico</label>
        <input
            id="email"
            type="email"
            name="email"
            placeholder="Ingrese su correo electrónico"
            value="{{ old('email') }}"
            required
            autofocus
            class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2"
            aria-describedby="emailHelp"
        />

        <button type="submit" class="mt-6 w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
            Enviar enlace
        </button>
    </form>
@endsection
