<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | SIPeIP1</title>

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <style>
    /* Tu CSS base (sin cambios salvo submenu) */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body {
      background-color: #f4f6f8;
      color: #333;
    }
    .header {
      background-color: rgb(5, 93, 137);
      color: white;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 10000;
    }
    .header-title {
      font-size: 1.2rem;
      display: flex;
      align-items: center;
    }
    .header img {
      height: 45px;
      margin-right: 15px;
    }
    .top-menu {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .top-menu a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }
    .top-menu a:hover {
      color: rgb(255, 227, 194);
    }
    .logout-button {
      background-color: rgb(52, 4, 245);
      color: white;
      padding: 7px 15px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      transition: background 0.3s ease;
      cursor: pointer;
    }
    .logout-button:hover {
      background-color: #c9302c;
    }
    .user-info {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 6px 15px;
      border-radius: 15px;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      user-select: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .user-info i {
      font-size: 1.2rem;
    }

    .container {
      display: flex;
      min-height: calc(100vh - 60px);
      gap: 1rem;
    }

    .sidebar {
      width: 260px;
      background-color: #1f2937;
      color: #eaeaea;
      padding-top: 20px;
      position: relative;
      user-select: none;
      z-index: 1000;
      overflow-y: auto;
      overflow-x: hidden;
      flex-shrink: 0;
      box-sizing: border-box;
    }
    .sidebar h3 {
      padding: 15px 25px;
      font-size: 1rem;
      border-bottom: 1px solid #33475b;
      color: #a3b1c6;
    }
    .sidebar ul {
      list-style: none;
      padding-left: 0;
    }
    .sidebar ul li a.menu-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      color: #eaeaea;
      text-decoration: none;
      user-select: none;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
      position: relative;

      white-space: normal;
      word-break: break-word;
      max-width: 220px;
      box-sizing: border-box;
    }
    .sidebar ul li a.menu-link:hover,
    .sidebar ul li a.menu-link.active {
      background-color: rgb(7, 83, 249);
      color: white;
    }
    .has-submenu {
      position: relative;
      cursor: pointer;
    }
    /* Submenu oculto por defecto */
    .submenu {
      display: none;
      flex-direction: column;
      background-color: #374151;
      padding-left: 20px;
      box-sizing: border-box;
      position: relative;
      margin-top: 4px;
      border-left: 3px solid #10b981;
    }
    .submenu li {
      padding: 10px 10px;
      background-color: #4b5563;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #e2e8f0;
      white-space: nowrap;
      border-radius: 3px;
      margin-bottom: 4px;
      transition: background-color 0.2s;
    }
    .submenu li:hover,
    .submenu li a.active {
      background-color: #10b981;
      color: white;
    }
    .toggle-icon {
      margin-left: auto;
      font-size: 0.8rem;
      color: #9ca3af;
      user-select: none;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    /* Girar icono cuando está abierto */
    .has-submenu.open > a > .toggle-icon {
      transform: rotate(90deg);
    }
    .content {
      flex-grow: 1;
      padding: 40px;
      background-color: #ffffff;
      min-height: calc(100vh - 60px);
      overflow-y: auto;
      z-index: 0;
      box-sizing: border-box;
    }
    .content h2 {
      color: #002f46;
      margin-bottom: 20px;
    }

    /* Mostrar submenu si .open está presente */
    .has-submenu.open > .submenu {
      display: flex;
    }

    /* --- NUEVO: Submenu anidado (submenu dentro de submenu) --- */
    /* Más espacio arriba para que se vea separado */
    .submenu .submenu {
      margin-top: 12px; /* espacio vertical */
      padding-left: 25px; /* indentación mayor */
      border-left-color: #059669; /* verde ligeramente diferente */
      border-top: 2px solid #10b981; /* línea superior para separación */
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-title">
      <img src="{{ asset('snp.png') }}" alt="Logo SNP" />
      Sistema Integrado de Planificación e Inversión Pública - SIPeIP1
    </div>
    <div class="top-menu">
      <div class="user-info" title="Usuario autenticado" aria-label="Usuario autenticado">
        <i class="fas fa-user-circle" aria-hidden="true"></i>
        Usuario: {{ Auth::user()->Nombre }} {{ Auth::user()->Apellido }}
      </div>

      {{-- Sólo mostrar estos enlaces para rol 1 (Administrador) --}}
      @if(Auth::user()->IdRol == 1)
        <a href="{{ route('roles.index') }}">Módulo de Roles</a>
        <a href="{{ route('usuarios.index') }}">Módulo de Usuarios</a>
        <a href="{{ route('instituciones.index') }}">Módulo de Configuración Institucional</a>
      @endif

      {{-- Para rol técnico (2), sólo algunos módulos --}}
      @if(Auth::user()->IdRol == 2)
        <a href="{{ route('usuarios.index') }}">Módulo de Usuarios</a>
        <a href="{{ route('instituciones.index') }}">Módulo de Configuración Institucional</a>
      @endif

      {{-- Para rol lector (3), sólo Configuración Institucional --}}
      @if(Auth::user()->IdRol == 3)
        <a href="{{ route('instituciones.index') }}">Módulo de Configuración Institucional</a>
      @endif

      <form
        id="logout-form"
        action="{{ route('logout') }}"
        method="POST"
        style="display: inline;"
      >
        @csrf
        <button type="submit" class="logout-button">Cerrar Sesión</button>
      </form>
    </div>
  </div>

  @php
    $currentRouteName = request()->route()->getName();
    $currentTipo = request('tipo', '');

    $objetivosActive = false;
    $tipoActivo = '';

    if (str_starts_with($currentRouteName, 'objetivos.')) {
        $tipoActivo = $currentTipo;
        $objetivosActive = true;
    }

    $proyectosActive = request()->routeIs('planes.*') || request()->routeIs('proyectos.*') || request()->routeIs('programas.*') || request()->routeIs('cronogramas.*') || request()->routeIs('presupuestos.*');
    $alineacionesActive = request()->routeIs('objetivos.alineaciones.*');

    $tipoParam = $tipo ?? null;
    $objetivoParam = $objetivo ?? null;
  @endphp

  <div class="container">
    <nav class="sidebar" role="navigation" aria-label="Menú principal">
      <h3>Módulos</h3>
      <ul>
        {{-- Módulo de Roles: solo para administradores (IdRol = 1) --}}
        @if(Auth::user()->IdRol == 1)
        <li class="has-submenu {{ request()->routeIs('roles.*') ? 'open' : '' }}">
          <a
            href="{{ route('roles.index') }}"
            class="menu-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
            aria-expanded="{{ request()->routeIs('roles.*') ? 'true' : 'false' }}"
            aria-haspopup="true"
            tabindex="0"
          >
            <i class="fas fa-user-shield" aria-hidden="true"></i> Módulo de Roles
            <span class="toggle-icon" aria-hidden="true">▶</span>
          </a>
        </li>
        @endif

        {{-- Módulo de Usuarios: para administradores y técnicos (IdRol = 1 o 2) --}}
        @if(in_array(Auth::user()->IdRol, [1, 2]))
        <li class="has-submenu {{ request()->routeIs('usuarios.*') ? 'open' : '' }}">
          <a
            href="{{ route('usuarios.index') }}"
            class="menu-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
            aria-expanded="{{ request()->routeIs('usuarios.*') ? 'true' : 'false' }}"
            aria-haspopup="true"
            tabindex="0"
          >
            <i class="fas fa-users" aria-hidden="true"></i> Módulo de Usuarios
            <span class="toggle-icon" aria-hidden="true">▶</span>
          </a>
        </li>
        @endif

        {{-- Módulo Configuración Institucional: para todos --}}
        <li>
          <a
            href="{{ route('instituciones.index') }}"
            class="menu-link {{ request()->routeIs('instituciones.*') ? 'active' : '' }}"
            tabindex="0"
          >
            <i class="fas fa-cogs" aria-hidden="true"></i> Módulo de Configuración Institucional
          </a>
        </li>

        {{-- Módulo de Gestión de Objetivos Estratégicos: para administradores y técnicos --}}
        @if(in_array(Auth::user()->IdRol, [1, 2]))
        <li class="has-submenu {{ $objetivosActive ? 'open' : '' }}">
          <a
            href="#"
            class="menu-link"
            tabindex="0"
            aria-haspopup="true"
            aria-expanded="{{ $objetivosActive ? 'true' : 'false' }}"
          >
            <i class="fas fa-bullseye" aria-hidden="true"></i> Módulo de Gestión de Objetivos Estratégicos
            <span class="toggle-icon" aria-hidden="true">▶</span>
          </a>
          <ul
            class="submenu"
            role="menu"
            aria-label="Submenú de objetivos estratégicos"
          >
            <li role="none">
              <a
                href="{{ route('objetivos.index', ['tipo' => 'institucional']) }}"
                class="menu-link {{ ($tipoActivo === 'institucional') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-building" aria-hidden="true"></i> Objetivos Institucionales
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('objetivos.index', ['tipo' => 'plan_nacional']) }}"
                class="menu-link {{ ($tipoActivo === 'plan_nacional') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-flag" aria-hidden="true"></i> Objetivos del Plan Nacional de Desarrollo
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('objetivos.index', ['tipo' => 'ods']) }}"
                class="menu-link {{ ($tipoActivo === 'ods') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-globe" aria-hidden="true"></i> Objetivos de Desarrollo Sostenible (ODS)
              </a>
            </li>

            {{-- ENLACE SIMPLE ALINEACIONES, sin submenu ni toggle --}}
            @if ($tipoParam && $objetivoParam)
            <li role="none">
              <a
                href="{{ route('objetivos.alineaciones.index', ['tipo' => $tipoParam, 'objetivo' => $objetivoParam->id]) }}"
                class="menu-link {{ request()->routeIs('objetivos.alineaciones.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-link" aria-hidden="true"></i> Alineaciones
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        {{-- Módulo de Proyectos de Inversión (Planes, Proyectos y Programas): para administradores y técnicos --}}
        @if(in_array(Auth::user()->IdRol, [1, 2]))
        <li class="has-submenu {{ $proyectosActive ? 'open' : '' }}">
          <a
            href="#"
            class="menu-link"
            tabindex="0"
            aria-haspopup="true"
            aria-expanded="{{ $proyectosActive ? 'true' : 'false' }}"
          >
            <i class="fas fa-project-diagram" aria-hidden="true"></i> Módulo de Proyectos de Inversión (Planes, Proyectos y Programas)
            <span class="toggle-icon" aria-hidden="true">▶</span>
          </a>
          <ul
            class="submenu"
            role="menu"
            aria-label="Submenú de proyectos de inversión"
          >
            <li role="none">
              <a
                href="{{ route('planes.index') }}"
                class="menu-link {{ request()->routeIs('planes.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-file-alt" aria-hidden="true"></i> Planes
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('proyectos.index') }}"
                class="menu-link {{ request()->routeIs('proyectos.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-tasks" aria-hidden="true"></i> Proyectos
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('programas.index') }}"
                class="menu-link {{ request()->routeIs('programas.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-layer-group" aria-hidden="true"></i> Programas
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('cronogramas.index') }}"
                class="menu-link {{ request()->routeIs('cronogramas.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-calendar-alt" aria-hidden="true"></i> Cronograma
              </a>
            </li>
            <li role="none">
              <a
                href="{{ route('presupuestos.index') }}"
                class="menu-link {{ request()->routeIs('presupuestos.*') ? 'active' : '' }}"
                role="menuitem"
                tabindex="0"
              >
                <i class="fas fa-dollar-sign" aria-hidden="true"></i> Presupuesto
              </a>
            </li>
          </ul>
        </li>
        @endif

        {{-- Módulo de Vinculaciones: para administradores y técnicos --}}
        @if(in_array(Auth::user()->IdRol, [1, 2]))
        <li class="has-submenu {{ request()->routeIs('vinculaciones.*') || request()->routeIs('metas.*') || request()->routeIs('indicadores.*') ? 'open' : '' }}">
          <a
            href="#"
            class="menu-link"
            tabindex="0"
            aria-haspopup="true"
            aria-expanded="{{ request()->routeIs('vinculaciones.*') || request()->routeIs('metas.*') || request()->routeIs('indicadores.*') ? 'true' : 'false' }}"
          >
            <i class="fas fa-link" aria-hidden="true"></i> Módulo de Vinculaciones
            <span class="toggle-icon" aria-hidden="true">▶</span>
          </a>
          <ul class="submenu" role="menu" aria-label="Submenú de vinculaciones">
            <li role="none">
              <a href="{{ route('vinculaciones.index') }}" class="menu-link {{ request()->routeIs('vinculaciones.*') ? 'active' : '' }}" role="menuitem" tabindex="0">
                <i class="fas fa-link" aria-hidden="true"></i> Vinculaciones
              </a>
            </li>
            <li role="none">
              <a href="{{ route('metas.index') }}" class="menu-link {{ request()->routeIs('metas.*') ? 'active' : '' }}" role="menuitem" tabindex="0">
                <i class="fas fa-bullseye" aria-hidden="true"></i> Metas
              </a>
            </li>
            <li role="none">
              <a href="{{ route('indicadores.index') }}" class="menu-link {{ request()->routeIs('indicadores.*') ? 'active' : '' }}" role="menuitem" tabindex="0">
                <i class="fas fa-chart-line" aria-hidden="true"></i> Indicadores
              </a>
            </li>
          </ul>
        </li>
        @endif

        {{-- Módulo de Reportes: para todos los roles --}}
        <li>
          <a
            href="{{ route('reportes.index') }}"
            class="menu-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}"
            tabindex="0"
          >
            <i class="fas fa-chart-bar" aria-hidden="true"></i> Módulo de Reportes
          </a>
        </li>
      </ul>
    </nav>

    <main class="content">
      @yield('content')
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const sidebar = document.querySelector(".sidebar");
      const items = sidebar.querySelectorAll(".has-submenu");

      let openItem = null;

      items.forEach(item => {
        const link = item.querySelector("a.menu-link");
        const toggleIcon = item.querySelector(".toggle-icon");

        function toggleMenu() {
          if (item.classList.contains("open")) {
            item.classList.remove("open");
            link.setAttribute("aria-expanded", "false");
            openItem = null;
          } else {
            // Cerrar submenu abierto antes si hay
            if (openItem && openItem !== item) {
              openItem.classList.remove("open");
              const openLink = openItem.querySelector("a.menu-link");
              if (openLink) openLink.setAttribute("aria-expanded", "false");
            }
            // Abrir submenu clickeado
            item.classList.add("open");
            link.setAttribute("aria-expanded", "true");
            openItem = item;
          }
        }

        // Click en link para toggle submenu SOLO SI href="#" (no redirigir)
        link.addEventListener("click", e => {
          if (link.getAttribute("href") === "#") {
            e.preventDefault();
            toggleMenu();
          }
        });

        // Teclado: Enter o Space para abrir/cerrar submenu
        link.addEventListener("keydown", e => {
          if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            toggleMenu();
          }
        });
      });
    });
  </script>
</body>
</html>
