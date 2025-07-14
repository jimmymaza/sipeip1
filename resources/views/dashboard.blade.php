@extends('layouts.app')

@section('content')
  <div style="
    background: linear-gradient(135deg, #4e9af1, #1e3c72);
    color: white;
    padding: 20px 25px;
    border-radius: 10px 0 0 10px;
    box-shadow: 3px 3px 12px rgba(0,0,0,0.2);
    max-width: 650px;
    margin-left: 0;
    display: flex;
    align-items: center;
    gap: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  ">
    <!-- Ícono estilo "saludo" -->
    <svg xmlns="http://www.w3.org/2000/svg" style="width:50px; height:50px; flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"/>
    </svg>

    <div style="flex-grow:1;">
      <h1 style="margin:0; font-size:1.8rem; font-weight: 700; letter-spacing: 0.03em;">
        Bienvenido, <span style="text-transform: capitalize;">{{ Auth::user()->Nombre }} {{ Auth::user()->Apellido }}</span>
      </h1>
      <p style="margin: 6px 0 0; font-size:1.1rem; color: #d1e8ff;">
        Tiene el rol de 
        <span style="
          background: #1565c0; 
          padding: 3px 10px; 
          border-radius: 15px; 
          font-weight: 600; 
          font-size: 1rem;
          box-shadow: 0 0 8px #1565c0a0;
          ">
          {{ Auth::user()->rol->Nombre }}
        </span>
      </p>
      <p style="margin-top: 12px; font-size: 1rem; font-style: italic; opacity: 0.85;">
        Seleccione un módulo para iniciar.
      </p>
    </div>
  </div>
@endsection
