<nav class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white flex flex-col">
    <!-- Logo / Título -->
    <div class="flex items-center justify-center h-20 border-b border-gray-700">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold select-none">
            Sistema SIPEIP1
        </a>
    </div>

    <!-- Menú -->
    <ul class="flex-grow p-4 space-y-4">
        <li>
            <a href="{{ route('dashboard') }}" 
               class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                Módulos
            </a>
        </li>

        <li>
            <a href="{{ route('usuarios.index') }}" 
               class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('usuarios.*') ? 'bg-gray-700' : '' }}">
                Usuarios
            </a>
        </li>

        <li>
            <a href="{{ route('roles.index') }}" 
               class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('roles.*') ? 'bg-gray-700' : '' }}">
                Roles
            </a>
        </li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="block w-full text-left py-2 px-4 rounded text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Cerrar sesión
                </button>
            </form>
        </li>
    </ul>
</nav>
