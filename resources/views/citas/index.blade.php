@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-calendar-check me-2 text-primary"></i>
                Citas
            </h3>
            <div class="subtitle">Gestión de citas clínicas</div>
        </div>

        <a href="{{ route('citas.create.paciente') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus"></i> Nueva Cita
        </a>
    </div>

    {{-- ===== ALERTA ===== --}}
    @if(session('success'))
        <div class="alert alert-success shadow-soft border-0">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== FILTROS ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">

                {{-- Paciente --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Paciente</label>
                    <input type="text"
                           name="paciente"
                           value="{{ request('paciente') }}"
                           class="form-control"
                           placeholder="Buscar por nombre">
                </div>

                {{-- Fecha --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fecha</label>
                    <input type="date"
                           name="fecha"
                           value="{{ request('fecha') }}"
                           class="form-control">
                </div>

                {{-- Estado --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="programada" {{ request('estado')=='programada' ? 'selected' : '' }}>Programadas</option>
                        <option value="atendida" {{ request('estado')=='atendida' ? 'selected' : '' }}>Atendidas</option>
                        <option value="cancelada" {{ request('estado')=='cancelada' ? 'selected' : '' }}>Canceladas</option>
                    </select>
                </div>

                {{-- Botones --}}
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100" title="Buscar">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request()->hasAny(['paciente','fecha','estado']))
                        <a href="{{ route('citas.index') }}"
                           class="btn btn-light w-100"
                           title="Limpiar filtros">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- ===== TABLA ===== --}}
    <div class="card shadow-soft">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-info">
                        <tr>
                            <th>Paciente</th>
                            <th>Fecha / Hora</th>
                            <th>Motivo</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center" width="220">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                            <tr>
                                <td>{{ $cita->paciente->nombre }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($cita->fecha_hora)) }}</td>
                                <td>{{ $cita->motivo }}</td>

                                {{-- ===== ESTADO ===== --}}
                                <td class="text-center">
                                    @if($cita->estado === 'programada')
                                        <span class="badge bg-warning text-dark mb-2 d-block shadow-sm">
                                            Programada
                                        </span>

                                        <div class="d-flex justify-content-center gap-1 mt-1">
                                            {{-- ATENDER --}}
                                            <form action="{{ route('citas.atender', $cita) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-success btn-sm rounded-circle shadow-sm"
                                                        title="Marcar como atendida"
                                                        onclick="return confirm('¿Marcar como atendida?')">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>

                                            {{-- CANCELAR --}}
                                            <form action="{{ route('citas.cancelar', $cita) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-danger btn-sm rounded-circle shadow-sm"
                                                        title="Cancelar cita"
                                                        onclick="return confirm('¿Cancelar cita?')">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        </div>

                                    @elseif($cita->estado === 'atendida')
                                        <span class="badge bg-success shadow-sm">
                                            <i class="bi bi-check-circle me-1"></i> Atendida
                                        </span>
                                    @else
                                        <span class="badge bg-danger shadow-sm">
                                            <i class="bi bi-x-circle me-1"></i> Cancelada
                                        </span>
                                    @endif
                                </td>

                                {{-- ===== ACCIONES ===== --}}
                                <td class="text-center">
                                    {{-- VER --}}
                                    <a href="{{ route('citas.show', $cita) }}" class="btn btn-outline-info btn-icon btn-sm"
                                       title="Ver cita">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- EDITAR (solo si NO está atendida) --}}
                                    @if($cita->estado !== 'atendida')
                                        <a href="{{ route('citas.edit', $cita) }}" class="btn btn-outline-warning btn-icon btn-sm"
                                           title="Editar cita">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif

                                    {{-- ELIMINAR --}}
                                    <form action="{{ route('citas.destroy', $cita) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon btn-sm"
                                                title="Eliminar cita"
                                                onclick="return confirm('¿Eliminar cita?')">
                                            <i class="bi bi-dash-circle"></i>
                                        </button>
                                    </form>

                                    {{-- ODONTOGRAMA --}}
                                    <a href="{{ route('pacientes.odontograma', $cita->paciente_id) }}"
                                       class="btn btn-outline-dark btn-icon btn-sm"
                                       title="Ver odontograma">
                                        <i class="fa-solid fa-teeth-open"></i>
                                    </a>

                                    {{-- HISTORIA CLÍNICA solo si está atendida --}}
                                    @if($cita->estado === 'atendida')
                                        <a href="{{ route('evolucion.create', $cita) }}"
                                           class="btn btn-sm btn-icon {{ $cita->evolucion ? 'btn-outline-success' : 'btn-primary' }}"
                                           title="{{ $cita->evolucion ? 'Ver nota evolutiva' : 'Crear nota evolutiva' }}">
                                            <i class="bi bi-file-medical"></i>
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No hay citas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
