@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af; font-weight: 700;">Listado de Vinculaciones</h1>

  @if (session('success'))
    <div style="margin-bottom: 20px; background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 12px 18px; border-radius: 5px;">
      {{-- Asegúrate que FontAwesome está cargado para mostrar el ícono --}}
      <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
      {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('vinculaciones.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: 700;">
    <i class="fas fa-plus" aria-hidden="true"></i> Crear Nueva Vinculación
  </a>

  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 1rem;">
    <thead>
      <tr style="background-color: #2563eb; color: white; font-weight: 700;">
        <th style="padding: 12px 15px; text-align: left;">ID</th>
        <th style="padding: 12px 15px; text-align: left;">Objetivo Institucional</th>
        <th style="padding: 12px 15px; text-align: left;">Meta</th>
        <th style="padding: 12px 15px; text-align: left;">Indicador</th>
        <th style="padding: 12px 15px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($vinculaciones as $vinculacion)
      <tr style="border-bottom: 1px solid #ddd; transition: background-color 0.2s;">
        <td style="padding: 10px 15px;">{{ $vinculacion->id }}</td>
        <td style="padding: 10px 15px;">{{ $vinculacion->objetivoInstitucional->nombre ?? 'N/A' }}</td>
        <td style="padding: 10px 15px;">
          @if($vinculacion->meta)
            <strong>Año:</strong> {{ $vinculacion->meta->anio }}<br>
            <strong>Valor:</strong> {{ $vinculacion->meta->valor_objetivo }}
          @else
            <span style="color: #6b7280;">Sin meta asignada</span>
          @endif
        </td>
        <td style="padding: 10px 15px;">{{ $vinculacion->indicador->nombre ?? 'N/A' }}</td>
        <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">
          <a href="{{ route('vinculaciones.edit', $vinculacion->id) }}" 
             style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;">
            <i class="fas fa-edit" aria-hidden="true"></i> Editar
          </a>

          <button type="button" 
                  class="btn-delete" 
                  data-id="{{ $vinculacion->id }}" 
                  data-nombre="Vinculación #{{ $vinculacion->id }}"
                  style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                  aria-label="Eliminar Vinculación {{ $vinculacion->id }}">
            <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
          </button>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" style="padding: 20px; text-align: center; color: #6b7280;">No hay vinculaciones registradas.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Modal para confirmar eliminación --}}
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px; font-weight: 700;">Confirmar eliminación</h2>
      <p style="font-size: 1rem;">
        ¿Estás seguro que deseas eliminar la vinculación con: <strong id="modal-vinculacion-nombre"></strong>?
      </p>
      <form id="form-delete" method="POST" action="">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>

  <style>
    table tbody tr:hover { background-color: #e0f2fe; }
    .modal-overlay {
      position: fixed; top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.5);
      display: flex; justify-content: center; align-items: center;
      z-index: 9999;
    }
    .modal-content {
      background: #fff;
      border: 3px solid #b91c1c;
      border-radius: 8px;
      padding: 30px 35px;
      width: 360px;
      text-align: center;
      box-shadow: 0 0 15px #b91c1c;
      animation: blink-border 1.2s infinite;
    }
    @keyframes blink-border {
      0%, 100% { border-color: #b91c1c; box-shadow: 0 0 15px #b91c1c; }
      50% { border-color: #ef4444; box-shadow: 0 0 25px #ef4444; }
    }
    .btn-confirm {
      background-color: #b91c1c; color: white;
      padding: 12px 22px; border: none; border-radius: 5px;
      cursor: pointer; margin-right: 12px; font-weight: 700;
      transition: background-color 0.3s ease;
    }
    .btn-cancel {
      background-color: #6b7280; color: #f9fafb;
      padding: 12px 22px; border: none; border-radius: 5px;
      cursor: pointer; font-weight: 700;
      transition: background-color 0.3s ease;
    }
    .btn-confirm:hover { background-color: #7f1d1d; }
    .btn-cancel:hover { background-color: #4b5563; }
  </style>

  <script>
    const modal = document.getElementById('modal-delete');
    const formDelete = document.getElementById('form-delete');
    const modalNombre = document.getElementById('modal-vinculacion-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        modalNombre.textContent = nombre;
        formDelete.action = "{{ url('vinculaciones') }}/" + id;
        modal.style.display = 'flex';
      });
    });

    btnCancel.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        modal.style.display = 'none';
      }
    });
  </script>
</div>
@endsection
