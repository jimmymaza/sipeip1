@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Listado de Roles</h1>

  <a href="{{ route('roles.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">
      <i class="fas fa-plus" aria-hidden="true"></i> Crear Nuevo Rol
  </a>

  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
    <thead>
      <tr style="background-color: #2563eb; color: white;">
        <th style="padding: 12px 15px; text-align: left; min-width: 70px;">ID</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 220px;">Nombre</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 350px;">Descripción</th>
        <th style="padding: 12px 15px; width: 220px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($roles as $rol)
      <tr style="border-bottom: 1px solid #ddd;">
        <td style="padding: 10px 15px;">{{ $rol->IdRol }}</td>
        <td style="padding: 10px 15px;">{{ $rol->Nombre }}</td>
        <td style="padding: 10px 15px;">{{ $rol->Descripcion }}</td>
        <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">
          <a href="{{ route('roles.edit', $rol->IdRol) }}" 
             style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;"
             aria-label="Editar rol {{ $rol->Nombre }}">
            <i class="fas fa-edit" aria-hidden="true"></i> Editar
          </a>

          <button type="button" 
                  class="btn-delete" 
                  data-rolid="{{ $rol->IdRol }}" 
                  data-rolnombre="{{ $rol->Nombre }}"
                  style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                  aria-label="Eliminar rol {{ $rol->Nombre }}">
            <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el rol: <strong id="modal-rol-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>

  <style>
    /* Tabla */
    table thead tr {
      background-color: #2563eb; /* Azul accesible */
      color: white;
    }
    table tbody tr:hover {
      background-color: #e0f2fe; /* Hover claro */
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
      border: 3px solid #b91c1c; /* rojo más accesible */
      border-radius: 8px;
      padding: 30px 35px;
      width: 360px;
      text-align: center;
      box-shadow: 0 0 15px #b91c1c;
      animation: blink-border 1.2s infinite;
      outline: none;
    }

    @keyframes blink-border {
      0%, 100% { border-color: #b91c1c; box-shadow: 0 0 15px #b91c1c; }
      50% { border-color: #ef4444; box-shadow: 0 0 25px #ef4444; }
    }

    /* Botones */
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
  </style>

  <script>
    // Para accesibilidad, cuando se abre modal, el foco va al modal
    const modal = document.getElementById('modal-delete');
    const formDelete = document.getElementById('form-delete');
    const modalRolNombre = document.getElementById('modal-rol-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const rolId = button.getAttribute('data-rolid');
        const rolNombre = button.getAttribute('data-rolnombre');

        modalRolNombre.textContent = rolNombre;
        formDelete.action = `/roles/${rolId}`;
        
        modal.style.display = 'flex';
        modal.focus();  // Foco en modal para screen readers y teclado
      });
    });

    btnCancel.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Cerrar modal con Escape
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.style.display === 'flex') {
        modal.style.display = 'none';
      }
    });
  </script>
</div>
@endsection
