@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Listado de Instituciones</h1>

  <a href="{{ route('instituciones.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">
      <i class="fas fa-plus" aria-hidden="true"></i> Crear Nueva Institución
  </a>

  @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
    <thead>
      <tr style="background-color: #2563eb; color: white;">
        <th style="padding: 12px 15px; text-align: left; min-width: 50px;">ID</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 180px;">Nombre</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 130px;">Código</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 220px;">Subsector</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 130px;">Nivel Gobierno</th>
        <th style="padding: 12px 15px; text-align: left; min-width: 90px;">Estado</th>
        <th style="padding: 12px 15px; width: 230px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($instituciones as $institucion)
      <tr style="border-bottom: 1px solid #ddd;">
        <td style="padding: 10px 15px;">{{ $institucion->IdInstitucion }}</td>
        <td style="padding: 10px 15px;">{{ $institucion->Nombre }}</td>
        <td style="padding: 10px 15px;">{{ $institucion->Codigo }}</td>
        <td style="padding: 10px 15px;">{{ $institucion->Subsector }}</td>
        <td style="padding: 10px 15px;">{{ $institucion->NivelGobierno }}</td>
        <td>{{ $institucion->Estado ? 'Activo' : 'Inactivo' }}</td>
        <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">
          <a href="{{ route('instituciones.edit', $institucion->IdInstitucion) }}" 
             style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;"
             aria-label="Editar institución {{ $institucion->Nombre }}">
            <i class="fas fa-edit" aria-hidden="true"></i> Editar
          </a>

          <button type="button" 
                  class="btn-delete" 
                  data-institucionid="{{ $institucion->IdInstitucion }}" 
                  data-institucion="{{ $institucion->Nombre }}"
                  style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                  aria-label="Eliminar institución {{ $institucion->Nombre }}">
            <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
          </button>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align: center; padding: 1rem;">No hay instituciones registradas.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Paginación personalizada solo con Anterior y Siguiente --}}
  @if ($instituciones->hasPages())
    <nav aria-label="Paginación">
      <ul style="list-style: none; display: flex; justify-content: center; gap: 12px; padding: 0;">
        {{-- Botón Anterior --}}
        @if ($instituciones->onFirstPage())
          <li style="color: #aaa; padding: 8px 16px; border: 1px solid #ccc; border-radius: 4px;">Anterior</li>
        @else
          <li>
            <a href="{{ $instituciones->previousPageUrl() }}" style="text-decoration:none; color:#2563eb; padding: 8px 16px; border: 1px solid #2563eb; border-radius: 4px;">
              ← Anterior
            </a>
          </li>
        @endif

        {{-- Botón Siguiente --}}
        @if ($instituciones->hasMorePages())
          <li>
            <a href="{{ $instituciones->nextPageUrl() }}" style="text-decoration:none; color:#2563eb; padding: 8px 16px; border: 1px solid #2563eb; border-radius: 4px;">
              Siguiente →
            </a>
          </li>
        @else
          <li style="color: #aaa; padding: 8px 16px; border: 1px solid #ccc; border-radius: 4px;">Siguiente</li>
        @endif
      </ul>
    </nav>
  @endif

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar la institución: <strong id="modal-institucion-nombre"></strong>?</p>
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
      background-color: #2563eb;
      color: white;
    }
    table tbody tr:hover {
      background-color: #e0f2fe;
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
    const modal = document.getElementById('modal-delete');
    const formDelete = document.getElementById('form-delete');
    const modalInstitucionNombre = document.getElementById('modal-institucion-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const institucionId = button.getAttribute('data-institucionid');
        const institucionNombre = button.getAttribute('data-institucion');

        modalInstitucionNombre.textContent = institucionNombre;
        formDelete.action = `/instituciones/${institucionId}`;
        
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
</div>
@endsection
