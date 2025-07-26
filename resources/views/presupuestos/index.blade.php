@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px 0 30px 10px; padding: 0 10px; font-family: Arial, sans-serif;">
  <h1 style="margin-bottom: 20px; color: #1e40af;">Presupuestos</h1>

  <a href="{{ route('presupuestos.create') }}" 
     style="display: inline-block; margin-bottom: 15px; background-color: #2563eb; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">
      <i class="fas fa-plus" aria-hidden="true"></i> Nuevo Presupuesto
  </a>

  @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  {{-- Contenedor con scroll horizontal si la tabla es ancha --}}
  <div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; min-width: 900px;">
      <thead>
        <tr style="background-color: #2563eb; color: white;">
          <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Monto</th>
          <th style="padding: 12px 10px; min-width: 160px; text-align: left;">Fuente</th>
          <th style="padding: 12px 10px; min-width: 100px; text-align: left;">Año</th>
          <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Plan</th>
          <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Programa</th>
          <th style="padding: 12px 10px; min-width: 140px; text-align: left;">Proyecto</th>
          <th style="padding: 12px 10px; width: 160px; text-align: center;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($presupuestos as $p)
        <tr style="border-bottom: 1px solid #ddd;">
          <td style="padding: 10px 10px;">${{ number_format($p->monto, 2) }}</td>
          <td style="padding: 10px 10px;" title="{{ $p->fuente_financiamiento }}">{{ \Illuminate\Support\Str::limit($p->fuente_financiamiento, 40, '...') }}</td>
          <td style="padding: 10px 10px;">{{ $p->anio }}</td>
          <td style="padding: 10px 10px;">{{ $p->plan->nombre ?? '-' }}</td>
          <td style="padding: 10px 10px;">{{ $p->programa->nombre ?? '-' }}</td>
          <td style="padding: 10px 10px;">{{ $p->proyecto->nombre ?? '-' }}</td>
          <td style="padding: 10px 10px; text-align: center; white-space: nowrap;">
            <a href="{{ route('presupuestos.edit', $p->id) }}" 
               style="text-decoration: none; color: #2563eb; margin-right: 10px; font-weight: 600;"
               aria-label="Editar presupuesto {{ $p->id }}">
              <i class="fas fa-edit" aria-hidden="true"></i> Editar
            </a>

            <button type="button" 
                    class="btn-delete" 
                    data-presupuestoid="{{ $p->id }}" 
                    data-presupuestonombre="Monto ${{ number_format($p->monto, 2) }}"
                    style="background: none; border: none; color: #b91c1c; cursor: pointer; font-weight: 600; font-size: 0.9rem;"
                    aria-label="Eliminar presupuesto {{ $p->id }}">
              <i class="fas fa-trash-alt" aria-hidden="true"></i> Eliminar
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align: center; padding: 1rem;">No hay presupuestos registrados.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación mejorada --}}
  @if ($presupuestos->hasPages())
  <div class="d-flex justify-content-center mt-3 mb-5" role="navigation" aria-label="Paginación">
    <ul class="pagination">
      {{-- Botón Anterior --}}
      @if ($presupuestos->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
          <span class="page-link" aria-hidden="true">← Anterior</span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $presupuestos->previousPageUrl() }}" rel="prev" aria-label="Anterior">← Anterior</a>
        </li>
      @endif

      {{-- Páginas intermedias --}}
      @foreach(range(1, $presupuestos->lastPage()) as $page)
        @if ($page == $presupuestos->currentPage())
          <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
        @else
          <li class="page-item"><a class="page-link" href="{{ $presupuestos->url($page) }}">{{ $page }}</a></li>
        @endif
      @endforeach

      {{-- Botón Siguiente --}}
      @if ($presupuestos->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $presupuestos->nextPageUrl() }}" rel="next" aria-label="Siguiente">Siguiente →</a>
        </li>
      @else
        <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
          <span class="page-link" aria-hidden="true">Siguiente →</span>
        </li>
      @endif
    </ul>
  </div>
  @endif

  <!-- Modal Confirmación Eliminar -->
  <div id="modal-delete" class="modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-desc" tabindex="-1">
    <div class="modal-content">
      <h2 id="modal-title" style="color: #b91c1c; margin-bottom: 15px;">Confirmar eliminación</h2>
      <p id="modal-desc">¿Estás seguro que deseas eliminar el presupuesto: <strong id="modal-presupuesto-nombre"></strong>?</p>
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

    .pagination {
      display: flex;
      list-style: none;
      gap: 8px;
      padding-left: 0;
    }
    .pagination .page-item {
      border: 1.5px solid #2563eb;
      border-radius: 6px;
    }
    .pagination .page-item .page-link {
      padding: 8px 14px;
      color: #2563eb;
      text-decoration: none;
      font-weight: 600;
      display: block;
    }
    .pagination .page-item.disabled .page-link,
    .pagination .page-item.disabled .page-link:hover {
      color: #aaa;
      cursor: default;
      background-color: #f9f9f9;
    }
    .pagination .page-item.active .page-link {
      background-color: #2563eb;
      color: white;
      cursor: default;
      border-color: #2563eb;
    }

    /* Modal Styles */
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
    const modalPresupuestoNombre = document.getElementById('modal-presupuesto-nombre');
    const btnCancel = modal.querySelector('.btn-cancel');

    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', () => {
        const presupuestoId = button.getAttribute('data-presupuestoid');
        const presupuestoNombre = button.getAttribute('data-presupuestonombre');

        modalPresupuestoNombre.textContent = presupuestoNombre;
        formDelete.action = `/presupuestos/${presupuestoId}`;
        
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
