@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Listado de Proyectos</h1>

  {{-- ✅ Mensaje de éxito --}}
  @if (session('success'))
    <div style="margin-bottom: 20px; background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 12px 18px; border-radius: 5px;">
      <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
      {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('proyectos.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;"
     aria-label="Crear nuevo proyecto">
      <i class="fas fa-plus" aria-hidden="true"></i> Crear Nuevo Proyecto
  </a>

  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
    <thead>
      <tr style="background-color: #2563eb; color: white;">
        <th style="padding: 12px 15px; text-align: left;">ID</th>
        <th style="padding: 12px 15px; text-align: left;">Código</th>
        <th style="padding: 12px 15px; text-align: left;">Nombre</th>
        <th style="padding: 12px 15px; text-align: left;">Descripción</th>
        <th style="padding: 12px 15px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($proyectos as $proyecto)
      <tr style="border-bottom: 1px solid #ddd;">
        <td style="padding: 10px 15px;">{{ $proyecto->id }}</td>
        <td style="padding: 10px 15px;">{{ $proyecto->codigo }}</td>
        <td style="padding: 10px 15px;">{{ $proyecto->nombre }}</td>
        <td style="padding: 10px 15px;">{{ $proyecto->descripcion }}</td>
        <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">
          <a href="{{ route('proyectos.edit', $proyecto->id) }}" 
             style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;"
             aria-label="Editar proyecto {{ $proyecto->nombre }}">
            <i class="fas fa-edit" aria-hidden="true"></i> Editar
          </a>

          <button type="button" 
                  class="btn-delete" 
                  data-proyectoid="{{ $proyecto->id }}" 
                  data-proyectonombre="{{ $proyecto->nombre }}"
                  style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                  aria-label="Eliminar proyecto {{ $proyecto->nombre }}">
            <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Modal de confirmación --}}
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="0">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el proyecto: <strong id="modal-proyecto-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>

  <style>
    table tbody tr:hover {
      background-color: #e0f2fe;
    }

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

    .modal-content {
      background: #fff;
      border: 3px solid #b91c1c;
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
    const modalNombre = document.getElementById('modal-proyecto-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const proyectoId = button.getAttribute('data-proyectoid');
        const proyectoNombre = button.getAttribute('data-proyectonombre');

        modalNombre.textContent = proyectoNombre;
        formDelete.action = "{{ url('proyectos') }}/" + proyectoId;
        
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
