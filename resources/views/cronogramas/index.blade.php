@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Cronogramas</h1>

  <a href="{{ route('cronogramas.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">
      <i class="fas fa-plus" aria-hidden="true"></i> Nuevo Cronograma
  </a>

  @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; table-layout: fixed;">
    <thead>
      <tr style="background-color: #2563eb; color: white;">
        <th class="hidden-column">ID</th>
        <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Plan</th>
        <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Programa</th>
        <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Proyecto</th>
        <th style="padding: 12px 10px; min-width: 280px; text-align: left; word-wrap: break-word;">Actividad</th>
        <th style="padding: 12px 10px; min-width: 100px; text-align: left;">Fecha Inicio</th>
        <th style="padding: 12px 10px; min-width: 100px; text-align: left;">Fecha Fin</th>
        <th style="padding: 12px 10px; min-width: 160px; text-align: left;">Responsable</th>
        <th style="padding: 12px 10px; min-width: 100px; text-align: left;">Estado</th>
        <th style="padding: 12px 10px; min-width: 240px; text-align: left; word-wrap: break-word;">Observaciones</th>
        <th style="padding: 12px 10px; width: 160px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($cronogramas as $c)
      <tr style="border-bottom: 1px solid #ddd;">
        <td class="hidden-column" style="padding: 10px 10px;">{{ $c->id }}</td>
        <td style="padding: 10px 10px;">{{ $c->plan->nombre ?? '-' }}</td>
        <td style="padding: 10px 10px;">{{ $c->programa->nombre ?? '-' }}</td>
        <td style="padding: 10px 10px;">{{ $c->proyecto->nombre ?? '-' }}</td>
        <td style="padding: 10px 10px; text-align: justify;" title="{{ $c->actividad }}">
          {{ Str::limit($c->actividad, 100, '...') }}
        </td>
        <td style="padding: 10px 10px;">{{ \Carbon\Carbon::parse($c->fecha_inicio)->format('Y-m-d') }}</td>
        <td style="padding: 10px 10px;">{{ \Carbon\Carbon::parse($c->fecha_fin)->format('Y-m-d') }}</td>
        <td style="padding: 10px 10px;">{{ $c->responsable }}</td>
        <td style="padding: 10px 10px;">{{ $c->estado }}</td>
        <td style="padding: 10px 10px; text-align: justify;" title="{{ $c->observaciones }}">
          {{ Str::limit($c->observaciones, 100, '...') }}
        </td>
        <td style="padding: 10px 10px; text-align: center; white-space: nowrap;">
          <a href="{{ route('cronogramas.edit', $c->id) }}" 
             style="text-decoration: none; color: #2563eb; margin-right: 10px; font-weight: 600;"
             aria-label="Editar cronograma {{ $c->actividad }}">
            <i class="fas fa-edit" aria-hidden="true"></i> Editar
          </a>

          <button type="button" 
                  class="btn-delete" 
                  data-cronogramaid="{{ $c->id }}" 
                  data-cronogramanombre="{{ $c->actividad }}"
                  style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                  aria-label="Eliminar cronograma {{ $c->actividad }}">
            <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
          </button>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="11" style="text-align: center; padding: 1rem;">No hay cronogramas registrados.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el cronograma: <strong id="modal-cronograma-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>

  <style>
    /* Ocultar columna ID */
    .hidden-column {
      display: none;
    }

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
    const modalCronogramaNombre = document.getElementById('modal-cronograma-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const cronogramaId = button.getAttribute('data-cronogramaid');
        const cronogramaNombre = button.getAttribute('data-cronogramanombre');

        modalCronogramaNombre.textContent = cronogramaNombre;
        formDelete.action = `/cronogramas/${cronogramaId}`;
        
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
