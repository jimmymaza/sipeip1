@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 0 10px; font-family: Arial, sans-serif;">

  <h1 style="margin-bottom: 20px; color: #1e40af;">Listado de Planes</h1>

  <a href="{{ route('planes.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;"
     aria-label="Crear nuevo plan">
    <i class="fas fa-plus" aria-hidden="true"></i> Crear Nuevo Plan
  </a>

  <table role="grid" aria-describedby="table-description" style="width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 0.92rem;">
    <caption id="table-description" style="text-align: left; margin-bottom: 10px;">Listado con todos los planes registrados en el sistema</caption>
    <thead>
      <tr style="background-color: #2563eb; color: white;">
        <th scope="col" style="padding: 12px;">ID</th>
        <th scope="col" style="padding: 12px;">Código</th>
        <th scope="col" style="padding: 12px;">Nombre</th>
        <th scope="col" style="padding: 12px;">Descripción</th>
        <th scope="col" style="padding: 12px;">Estado</th>
        <th scope="col" style="padding: 12px;">Fecha Inicio</th>
        <th scope="col" style="padding: 12px;">Fecha Fin</th>
        <th scope="col" style="padding: 12px;">Creado</th>
        <th scope="col" style="padding: 12px;">Actualizado</th>
        <th scope="col" style="padding: 12px; text-align: center;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($planes as $plan)
        <tr style="border-bottom: 1px solid #ddd;">
          <td style="padding: 10px;">{{ $plan->id }}</td>
          <td style="padding: 10px;">{{ $plan->codigo }}</td>
          <td style="padding: 10px;">{{ $plan->nombre }}</td>
          <td style="padding: 10px;">{{ $plan->descripcion }}</td>
          <td style="padding: 10px; text-transform: capitalize;">{{ $plan->estado }}</td>
          <td style="padding: 10px;">{{ optional($plan->fecha_inicio)->format('Y-m-d') ?? '—' }}</td>
          <td style="padding: 10px;">{{ optional($plan->fecha_fin)->format('Y-m-d') ?? '—' }}</td>
          <td style="padding: 10px;">{{ $plan->created_at ? $plan->created_at->format('Y-m-d H:i:s') : '—' }}</td>
          <td style="padding: 10px;">{{ $plan->updated_at ? $plan->updated_at->format('Y-m-d H:i:s') : '—' }}</td>
          <td style="padding: 10px; text-align: center; white-space: nowrap;">
            <a href="{{ route('planes.edit', $plan->id) }}" 
               style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;"
               aria-label="Editar plan {{ $plan->nombre }}">
              <i class="fas fa-edit" aria-hidden="true"></i> Editar
            </a>
            <button type="button" 
                    class="btn-delete" 
                    data-planid="{{ $plan->id }}" 
                    data-plannombre="{{ $plan->nombre }}"
                    style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600;"
                    aria-label="Eliminar plan {{ $plan->nombre }}">
              <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" style="text-align: center; padding: 20px;">No hay planes registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Modal eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content" role="document">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el plan: <strong id="modal-plan-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="" style="margin-top: 20px;">
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
      width: 360px; text-align: center;
      box-shadow: 0 0 15px #b91c1c;
      animation: blink-border 1.2s infinite;
    }
    @keyframes blink-border {
      0%, 100% { border-color: #b91c1c; box-shadow: 0 0 15px #b91c1c; }
      50% { border-color: #ef4444; box-shadow: 0 0 25px #ef4444; }
    }
    .btn-confirm, .btn-cancel {
      padding: 12px 22px; border-radius: 5px;
      font-weight: 700; font-size: 1rem;
      border: none; cursor: pointer;
    }
    .btn-confirm { background-color: #b91c1c; color: white; margin-right: 12px; }
    .btn-confirm:hover { background-color: #7f1d1d; }
    .btn-cancel { background-color: #6b7280; color: white; }
    .btn-cancel:hover { background-color: #4b5563; }
  </style>

  <script>
    const modal = document.getElementById('modal-delete');
    const formDelete = document.getElementById('form-delete');
    const modalNombre = document.getElementById('modal-plan-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const planId = button.getAttribute('data-planid');
        const planNombre = button.getAttribute('data-plannombre');
        modalNombre.textContent = planNombre;
        formDelete.action = "{{ url('planes') }}/" + planId;
        modal.style.display = 'flex';
        modal.focus();
      });
    });

    btnCancel.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') modal.style.display = 'none';
    });
  </script>
</div>
@endsection
