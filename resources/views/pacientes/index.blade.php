@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-tooth me-2 text-primary"></i>
                Pacientes
            </h3>
            <div class="subtitle">Gestión clínica dental</div>
        </div>

        <a href="{{ route('pacientes.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus"></i> Nuevo paciente
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
            <form method="GET" action="{{ route('pacientes.index') }}" class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Paciente</label>
                    <input type="text" name="nombre" class="form-control"
                           placeholder="Nombre del paciente"
                           value="{{ request('nombre') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" name="telefono" class="form-control"
                           placeholder="Teléfono"
                           value="{{ request('telefono') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="text" name="email" class="form-control"
                           placeholder="Email"
                           value="{{ request('email') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request()->hasAny(['nombre','telefono','email']))
                        <a href="{{ route('pacientes.index') }}"
                           class="btn btn-light w-100">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ===== TABLA ===== --}}
    <div class="card shadow-soft">
        <div class="card-body p-0 ">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-info">
                    <tr>
                        <th class="ps-4">Paciente</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center" width="220">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td class="ps-4 fw-semibold">
                                {{ $paciente->nombre }}
                            </td>
                            <td>{{ $paciente->telefono }}</td>
                            <td>{{ $paciente->email }}</td>

                            <td class="text-center">
                                @if($paciente->es_ortodoncia)
                                    <i class="fa-solid fa-tooth text-primary"
                                       data-bs-toggle="tooltip"
                                       title="Ortodoncia"></i>
                                @else
                                    <i class="fa-solid fa-tooth text-secondary"
                                       data-bs-toggle="tooltip"
                                       title="Consulta general"></i>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('pacientes.show', $paciente) }}"
                                   class="btn btn-outline-primary btn-icon"
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('pacientes.edit', $paciente) }}"
                                   class="btn btn-outline-warning btn-icon"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="{{ route('pacientes.historial', $paciente) }}"
                                   class="btn btn-outline-success btn-icon"
                                   title="Historial">
                                    <i class="bi bi-file-medical"></i>
                                </a>

                                <a href="{{ route('pacientes.odontograma', $paciente) }}"
                                   class="btn btn-outline-dark btn-icon"
                                   title="Odontograma">
                                    <i class="fa-solid fa-teeth-open"></i>
                                </a>

                                <form action="{{ route('pacientes.destroy', $paciente) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon"
                                            title="Eliminar"
                                            onclick="return confirm('¿Eliminar paciente?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No hay pacientes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
