<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'SIPEIP1') }}</title>
    
    {{-- Carga los assets con Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilos generales */
        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background-color: #f3f4f6;
        }

        /* Header superior */
        header {
            background-color: #1e40af;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Menú superior */
        nav.top-menu a {
            color: white;
            margin-right: 1.5rem;
            text-decoration: none;
            font-weight: 500;
        }

        nav.top-menu span {
            margin-right: 1.5rem;
            font-weight: bold;
        }

        nav.top-menu form button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        nav.top-menu form button:hover {
            background-color: red;
        }

        /* Sidebar lateral */
        aside.sidebar {
            width: 220px;
            height: calc(100vh - 64px); /* Altura menos header */
            position: fixed;
            top: 64px; /* Altura del header */
            left: 0;
            padding-top: 0.5rem;
            color: white;
            background-color: #374151;
        }

        /* Título de menú con animación */
        .menu-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 1.5rem 12px 0.5rem 12px;
            padding: 8px 12px;
            border-radius: 6px;
            text-align: center;
            color: white;
            letter-spacing: 1px;
            user-select: none;
            background: linear-gradient(270deg, #ff5722, #ff9800, #ff5722, #ffb74d);
            background-size: 600% 600%;
            animation: fireGradient 4s ease infinite;
            box-shadow: 0 0 10px 3px #ff5722;
        }

        @keyframes fireGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Links del sidebar */
        aside.sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            margin: 5px 12px;
            text-decoration: none;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            transition: filter 0.3s ease;
        }

        aside.sidebar nav a:hover {
            filter: brightness(85%);
        }

        aside.sidebar nav a.active {
            box-shadow: 0 0 10px 2px #ff9800;
        }

        /* Iconos SVG en sidebar */
        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Área principal de contenido */
        main.content {
            margin-left: 220px; /* Deja espacio para sidebar */
            padding: 2rem;
            max-width: 900px;
            background: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            min-height: calc(100vh - 64px);
        }
    </style>
</head>
<body>

<header>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid white; display: flex; align-items: center; justify-content: center; background-color: white;">
            <img src="{{ asset('snp.jpg') }}" alt="Logo SIPEIP" style="width: 32px; height: 32px; object-fit: contain;">
        </div>
        <div style="font-size: 1rem; font-weight: 600;">
            Sistema Integrado de Planificación e Inversión Pública - SIPEIP1
        </div>
    </div>

    <nav class="top-menu" aria-label="Menú principal">
        <a href="{{ route('dashboard') }}">Menú Principal</a>
        <a href="{{ route('usuarios.index') }}">Usuarios</a>
        <a href="{{ route('roles.index') }}">Roles</a>

        @if(Auth::check())
            <span>Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
        @endif

        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </nav>
</header>

<aside class="sidebar" aria-label="Menú lateral">
    <nav>
        <div class="menu-title">Módulos</div>

        <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}" style="background-color: #10b981;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.7 0 4-2 4-4s-1.3-4-4-4-4 2-4 4 1.3 4 4 4zm0 2c-3 0-6 1.5-6 4v2h12v-2c0-2.5-3-4-6-4z"/>
                </svg>
            </span>
            Gestión de Usuarios
        </a>

        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}" style="background-color: #f59e0b; color: black;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7v2c0 5.25 3.25 10.75 10 13 6.75-2.25 10-7.75 10-13V7l-10-5z"/>
                </svg>
            </span>
            Gestión de Roles
        </a>

        <a href="#" style="background-color: #3b82f6;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </span>
            Configuración Institucional
        </a>

        <a href="#" style="background-color: #8b5cf6;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8v4l3 3" />
                </svg>
            </span>
            Objetivos Estratégicos
        </a>

        <a href="#" style="background-color: #ef4444;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2v8h8v2h-8v8h-2v-8H3v-2h8V2h2z"/>
                </svg>
            </span>
            Proyectos de Inversión
        </a>

        <a href="#" style="background-color: #ec4899;">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 13h2v-2H3v2zm4 0h14v-2H7v2zM3 17h2v-2H3v2zm4 0h14v-2H7v2z" />
                </svg>
            </span>
            Reportes
        </a>
    </nav>
</aside>

<main class="content">
    {{-- Aquí se inyecta el contenido de cada vista --}}
    @yield('content')
</main>

</body>
</html>
