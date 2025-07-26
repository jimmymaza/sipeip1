@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Listado de Indicadores</h1>

  <a href="{{ route('indicadores.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">
      <i class="fas fa-plus" aria-hidden="true"></i> Crear Nuevo Indicador
  </a>

  @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  <div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; min-width: 900px;">
      <thead>
        <tr style="background-color: #2563eb; color: white;">
          <th style="padding: 12px 15px; text-align: left; min-width: 150px;">Código</th>
          <th style="padding: 12px 15px; text-align: left; min-width: 250px;">Nombre</th>
          <th style="padding: 12px 15px; text-align: left; min-width: 320px;">Descripción</th>
          <th style="padding: 12px 15px; text-align: left; min-width: 120px;">Unidad de Medida</th>
          <th style="padding: 12px 15px; text-align: left; min-width: 120px;">Estado</th>
          <th style="padding: 12px 15px; text-align: left; min-width: 160px;">Fecha Registro</th>
          {{-- <th style="padding: 12px 15px; text-align: left; min-width: 220px;">Responsable (Nombre - Rol)</th> --}}
          <th style="padding: 12px 15px; width: 160px; text-align: center;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($indicadores as $indicador)
        <tr style="border-bottom: 1px solid #ddd;">
          <td style="padding: 10px 15px;">{{ $indicador->codigo }}</td>
          <td style="padding: 10px 15px;">{{ $indicador->nombre }}</td>
          <td style="padding: 10px 15px;">{{ $indicador->descripcion }}</td>
          <td style="padding: 10px 15px;">{{ $indicador->unidad_medida }}</td>
          <td style="padding: 10px 15px; text-transform: capitalize;">{{ $indicador->estado }}</td>
          <td style="padding: 10px 15px;">{{ \Carbon\Carbon::parse($indicador->fecha_registro)->format('d/m/Y') }}</td>
          {{-- <td style="padding: 10px 15px;">
            @if($indicador->usuarioResponsable)
              {{ $indicador->usuarioResponsable->Nombre }} {{ $indicador->usuarioResponsable->Apellido }}
              ({{ $indicador->usuarioResponsable->rol->Nombre ?? 'Sin rol' }})
            @else
              N/A
            @endif
          </td> --}}
          <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">
            <a href="{{ route('indicadores.edit', $indicador->id) }}" 
               style="text-decoration: none; color: #2563eb; margin-right: 12px; font-weight: 600;"
               aria-label="Editar indicador {{ $indicador->id }}">
              <i class="fas fa-edit" aria-hidden="true"></i> Editar
            </a>

            <button type="button" 
                    class="btn-delete" 
                    data-indicadorid="{{ $indicador->id }}" 
                    data-indicadornombre="{{ $indicador->descripcion }}"
                    style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                    aria-label="Eliminar indicador {{ $indicador->id }}">
              <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align: center; padding: 1rem;">No hay indicadores registrados.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el indicador: <strong id="modal-indicador-nombre"></strong>?</p>
      <form id="form-delete" method="POST" action="" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-confirm">Sí, eliminar</button>
        <button type="button" class="btn-cancel">Cancelar</button>
      </form>
    </div>
  </div>

  <style>
    table thead tr {
      background-color: #2563eb;
      color: white;
    }
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
    const modalIndicadorNombre = document.getElementById('modal-indicador-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const indicadorId = button.getAttribute('data-indicadorid');
        const indicadorNombre = button.getAttribute('data-indicadornombre');

        modalIndicadorNombre.textContent = indicadorNombre;
        formDelete.action = `/indicadores/${indicadorId}`;
        
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
