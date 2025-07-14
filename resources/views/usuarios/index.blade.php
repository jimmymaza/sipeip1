@extends('layouts.app')

@section('content')
<div class="container-users">

  <h1 class="title">Listado de Usuarios</h1>

  <a href="{{ route('usuarios.create') }}" class="btn-create">
    <i class="fas fa-plus" aria-hidden="true"></i> Crear Nuevo Usuario
  </a>

  @if(session('success'))
    <div class="alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="table-responsive">
    <table class="table-users">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cédula</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->IdUsuario }}</td>
          <td>{{ $usuario->Cedula }}</td>
          <td>{{ $usuario->Nombre }}</td>
          <td>{{ $usuario->Apellido }}</td>
          <td>{{ $usuario->Correo }}</td>
          <td>{{ $usuario->Telefono }}</td>
          <td>{{ $usuario->rol->Nombre ?? 'Sin rol' }}</td>
          <td class="acciones">
            <a href="{{ route('usuarios.edit', $usuario->IdUsuario) }}" aria-label="Editar usuario {{ $usuario->Nombre }} {{ $usuario->Apellido }}">
              <i class="fas fa-edit"></i> Editar
            </a>

            <button type="button" 
                    class="btn-delete" 
                    data-usuarioid="{{ $usuario->IdUsuario }}" 
                    data-usuario="{{ $usuario->Nombre }} {{ $usuario->Apellido }}"
                    aria-label="Eliminar usuario {{ $usuario->Nombre }} {{ $usuario->Apellido }}">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" style="text-align: center; padding: 1rem;">No hay usuarios registrados.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1" style="display:none;">
    <div class="modal-content">
      <h2 id="modal-title">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el usuario: <strong id="modal-usuario-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>
</div>

<style>
  /* Contenedor general - pegado más a la izquierda, poco margen */
  .container-users {
    max-width: 100%;
    margin: 20px 0 20px 10px; /* margen izquierdo pequeño */
    padding: 0 10px;
    font-family: Arial, sans-serif;
  }

  .title {
    margin-bottom: 20px;
    color: #1e40af;
  }

  /* Botón crear */
  .btn-create {
    display: inline-block;
    margin-bottom: 15px;
    background-color: #2563eb;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
  }

  .btn-create:hover {
    background-color: #1d4ed8;
  }

  /* Mensaje éxito */
  .alert-success {
    background-color: #d1fae5;
    color: #065f46;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
  }

  /* Tabla responsive - permite scroll si se desborda */
  .table-responsive {
    overflow-x: auto;
    max-width: 100%;
  }

  /* Tabla usuarios */
  .table-users {
    width: 100%; /* usa todo el ancho posible dentro del contenedor */
    border-collapse: collapse;
    margin-bottom: 30px;
    table-layout: auto; /* deja que las columnas se ajusten al contenido */
  }

  .table-users thead tr {
    background-color: #2563eb;
    color: white;
  }

  /* Padding cómodo pero no muy ancho */
  .table-users thead th,
  .table-users tbody td {
    padding: 10px 12px;
    text-align: left;
    white-space: nowrap;
    vertical-align: middle;
  }

  .table-users tbody tr:hover {
    background-color: #e0f2fe;
  }

  .acciones {
    white-space: nowrap;
  }

  .acciones a,
  .acciones button {
    font-weight: 600;
    margin-right: 10px;
    cursor: pointer;
    border: none;
    background: none;
  }

  .acciones a {
    color: #2563eb;
    text-decoration: none;
  }

  .acciones a:hover {
    text-decoration: underline;
  }

  .acciones button {
    color: #b91c1c;
    font-size: 0.9rem;
  }

  .acciones button:hover {
    text-decoration: underline;
  }

  /* Modal Overlay */
  .modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  /* Modal Content */
  .modal-content {
    background: #fff;
    border: 3px solid #b91c1c;
    border-radius: 8px;
    padding: 30px 35px;
    width: 380px;
    text-align: center;
    box-shadow: 0 0 15px #b91c1c;
    animation: blink-border 1.2s infinite;
    outline: none;
  }

  @keyframes blink-border {
    0%, 100% { border-color: #b91c1c; box-shadow: 0 0 15px #b91c1c; }
    50% { border-color: #ef4444; box-shadow: 0 0 25px #ef4444; }
  }

  /* Botones modal */
  .btn-confirm {
    background-color: #b91c1c;
    color: white;
    padding: 12px 22px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 12px;
    font-weight: 700;
    font-size: 1rem;
    transition: background-color 0.3s ease;
  }
  .btn-confirm:hover,
  .btn-confirm:focus {
    background-color: #7f1d1d;
    outline: none;
  }

  .btn-cancel {
    background-color: #6b7280;
    color: #f9fafb;
    padding: 12px 22px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 700;
    font-size: 1rem;
    transition: background-color 0.3s ease;
  }
  .btn-cancel:hover,
  .btn-cancel:focus {
    background-color: #4b5563;
    outline: none;
  }

  /* Responsive para pantallas chicas */
  @media (max-width: 768px) {
    .table-users thead th,
    .table-users tbody td {
      padding: 8px 10px;
      font-size: 0.9rem;
      white-space: normal; /* para que se pueda partir en móviles */
    }

    .btn-create {
      padding: 8px 12px;
      font-size: 0.9rem;
    }

    .modal-content {
      width: 90vw;
      max-width: 400px;
      padding: 20px 25px;
    }
  }
</style>

<script>
  const modal = document.getElementById('modal-delete');
  const formDelete = document.getElementById('form-delete');
  const modalUsuarioNombre = document.getElementById('modal-usuario-nombre');
  const btnCancel = modal.querySelector('.btn-cancel');

  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
      const usuarioId = button.getAttribute('data-usuarioid');
      const usuarioNombre = button.getAttribute('data-usuario');

      modalUsuarioNombre.textContent = usuarioNombre;
      formDelete.action = `/usuarios/${usuarioId}`;

      modal.style.display = 'flex';
      modal.focus();
    });
  });

  btnCancel.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.style.display === 'flex') {
      modal.style.display = 'none';
    }
  });
</script>

@endsection
