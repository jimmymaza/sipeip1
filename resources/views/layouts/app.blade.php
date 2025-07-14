<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | SIPeIP1</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
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
      text-decoration: none;
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
    }

    .sidebar {
      width: 260px;
      background-color: #1f2937;
      color: #eaeaea;
      min-height: calc(100vh - 60px);
      padding-top: 20px;
      position: relative;
      z-index: 1;
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
      padding: 12px 25px;
      color: #eaeaea;
      text-decoration: none;
      user-select: none;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
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

    .submenu {
      display: none;
      flex-direction: column;
      background-color: #374151;
      position: absolute;
      left: 100%;
      top: 0;
      min-width: 230px;
      z-index: 9999;
      box-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    }

    .has-submenu:hover > .submenu,
    .has-submenu.open > .submenu {
      display: flex;
    }

    .submenu li {
      padding: 10px 20px;
      background-color: #4b5563;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #e2e8f0;
    }

    .submenu li:hover {
      background-color: #10b981;
      color: white;
    }

    .toggle-icon {
      margin-left: auto;
      font-size: 0.8rem;
      color: #9ca3af;
    }

    .content {
      flex-grow: 1;
      padding: 40px;
      background-color: #ffffff;
      min-height: calc(100vh - 60px);
      z-index: 0;
    }

    .content h2 {
      color: #002f46;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="header">
  <div class="header-title">
    <img src="{{ asset('snp.png') }}" alt="Logo SNP">
    Sistema Integrado de Planificación e Inversión Pública - SIPeIP1
  </div>
  <div class="top-menu">
    <div class="user-info" title="Usuario autenticado">
      <i class="fas fa-user-circle"></i>
      Usuario: {{ Auth::user()->Nombre }} {{ Auth::user()->Apellido }}
    </div>

    <a href="{{ route('roles.index') }}">Roles</a>
    <a href="{{ route('usuarios.index') }}">Usuarios</a>
    <a href="{{ route('instituciones.index') }}">Instituciones</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit" class="logout-button">Cerrar Sesión</button>
    </form>
  </div>
</div>

<div class="container">
  <div class="sidebar" role="navigation">
    <h3>Módulos</h3>
    <ul>
      <li class="has-submenu">
        <a href="{{ route('roles.index') }}" class="menu-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
          <i class="fas fa-user-shield"></i> Módulo de Roles <span class="toggle-icon">▶</span>
        </a>
      </li>

      <li class="has-submenu">
        <a href="{{ route('usuarios.index') }}" class="menu-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
          <i class="fas fa-users"></i> Módulo de Usuarios <span class="toggle-icon">▶</span>
        </a>
      </li>

      <li>
        <a href="{{ route('instituciones.index') }}" class="menu-link {{ request()->routeIs('instituciones.*') ? 'active' : '' }}">
          <i class="fas fa-cogs"></i> Configuración Institucional
        </a>
      </li>

      <li class="has-submenu">
        <a href="#" class="menu-link">
          <i class="fas fa-bullseye"></i> Objetivos <span class="toggle-icon">▶</span>
        </a>
        <ul class="submenu">
          <li><a href="#" class="menu-link"><i class="fas fa-building"></i> Institucionales</a></li>
          <li><a href="#" class="menu-link"><i class="fas fa-flag"></i> Plan Nacional</a></li>
          <li><a href="#" class="menu-link"><i class="fas fa-globe"></i> ODS</a></li>
        </ul>
      </li>

      <li class="has-submenu">
        <a href="#" class="menu-link">
          <i class="fas fa-project-diagram"></i> Proyectos de Inversión <span class="toggle-icon">▶</span>
        </a>
        <ul class="submenu">
          <li><a href="#" class="menu-link"><i class="fas fa-layer-group"></i> Programas</a></li>
          <li><a href="#" class="menu-link"><i class="fas fa-tasks"></i> Proyectos</a></li>
        </ul>
      </li>

      <li>
        <a href="#" class="menu-link">
          <i class="fas fa-chart-line"></i> Reportes
        </a>
      </li>
    </ul>
  </div>

  <div class="content">
    @yield('content')
  </div>
</div>

</body>
</html>
