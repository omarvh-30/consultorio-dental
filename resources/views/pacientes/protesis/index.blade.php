@php
    $protesisActiva = $paciente->protesisActiva;
    $historialProtesis = $paciente->protesis()
        ->orderByDesc('fecha_inicio')
        ->get();
@endphp


<div class="card border-0 shadow-sm mb-3">

    @if($protesisActiva || $historialProtesis->count() > 0)
        {{-- ================= HEADER TIPO SUMMARY (ESTILO ORTODONCIA) ================= --}}
        <div class="card-body">

            <div class="ortho-summary">

                {{-- ÍCONO --}}
                <div class="ortho-avatar bg-warning bg-opacity-25 text-white">
                    <i class="fa-solid fa-teeth-open"></i>
                </div>

                {{-- INFO PRINCIPAL --}}
                <div class="ortho-main">
                    <div class="ortho-label">
                        Tratamiento protésico
                    </div>

                    <div class="ortho-value">
                        @if($protesisActiva)
                            Prótesis {{ ucfirst($protesisActiva->tipo) }}
                        @else
                            Sin prótesis activa
                        @endif
                    </div>
                    <small class="opacity-75">
                        Registro y seguimiento clínico protésico
                    </small>
                </div>

                {{-- ESTADO + ACCIONES --}}
                <div class="d-flex flex-column align-items-end gap-2">

                    {{-- ESTADO --}}
                    @if($protesisActiva)
                        <span class="badge bg-warning text-dark">
                            Activa
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            Inactiva
                        </span>
                    @endif

                    {{-- BOTÓN NUEVA PRÓTESIS --}}
                    @if(!$protesisActiva)
                        <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalNuevaProtesis">
                            <i class="fa-solid fa-plus me-1"></i>
                            Nueva prótesis
                        </button>
                    @endif

                </div>

            </div>

        </div>
    @endif

    {{-- ================= BODY ================= --}}
    <div class="card-body">

        {{-- ===== PRÓTESIS ACTIVA ===== --}}
        @if($protesisActiva)
        <div class="card border-2 shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-semibold text-black mb-1">
                        <i class="fa-solid fa-circle-play me-1"></i>
                        Prótesis {{ ucfirst($protesisActiva->tipo) }} en curso
                    </div>

                    <div class="small text-muted">
                        <div><strong>Zona:</strong> {{ $protesisActiva->zona ?? '—' }}</div>
                        <div><strong>Inicio:</strong> {{ $protesisActiva->fecha_inicio->format('d/m/Y') }}</div>
                        <div><strong>Estado:</strong> Activa</div>
                    </div>

                    @if($protesisActiva->observaciones)
                        <div class="fst-italic text-muted small mt-2">
                            <strong>Observaciones :</strong> {{ $protesisActiva->observaciones }}
                        </div>
                    @endif
                </div>

                <div class="d-flex flex-column gap-2 text-end">
                    <button class="btn btn-outline-secondary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalSeguimientoProtesis">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i>
                        Seguimiento
                    </button>

{{-- 📄 MENÚ PDF PRÓTESIS --}}
<div class="dropdown">

    <button class="btn btn-danger btn-sm dropdown-toggle"
            data-bs-toggle="dropdown">
        <i class="fa-solid fa-file-pdf me-1"></i>
        Prótesis PDF
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">

        {{-- 👁 VER --}}
        <li>
            <a class="dropdown-item"
               target="_blank"
               href="{{ route('protesis.timeline.pdf', $protesisActiva) }}?view=1">
                <i class="fa-solid fa-eye me-2 text-primary"></i>
                Ver documento
            </a>
        </li>

        {{-- ⬇ DESCARGAR --}}
        <li>
            <a class="dropdown-item"
               href="{{ route('protesis.timeline.pdf', $protesisActiva) }}">
                <i class="fa-solid fa-download me-2 text-success"></i>
                Descargar
            </a>
        </li>

    </ul>
</div>

                    <button class="btn btn-outline-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalFinalizarProtesis">
                        <i class="fa-solid fa-check me-1"></i>
                        Finalizar
                    </button>
                </div>

            </div>
        </div>
        @endif

        {{-- ===== HISTORIAL DE PRÓTESIS ===== --}}
        @foreach($historialProtesis as $protesis)
            @if(!$protesisActiva || $protesis->id !== $protesisActiva->id)
            <div class="card mb-3 border
                {{ $protesis->estado === 'finalizada' ? 'border-success' : 'border-secondary' }}">

                <div class="card-body d-flex justify-content-between align-items-start">

                    <div>
                        <h6 class="mb-1">
                            Prótesis {{ ucfirst($protesis->tipo) }}
                            <span class="badge bg-{{ $protesis->estado === 'finalizada' ? 'success' : 'secondary' }} ms-2">
                                {{ ucfirst($protesis->estado) }}
                            </span>
                        </h6>

                        <div class="small text-muted">
                            <div><strong>Inicio:</strong> {{ $protesis->fecha_inicio->format('d/m/Y') }}</div>
                            <div><strong>Fin:</strong> {{ $protesis->fecha_termino?->format('d/m/Y') ?? '—' }}</div>
                        </div>
                    </div>

                    {{-- ===== ACCIONES ===== --}}
                    <div class="d-flex flex-column gap-2 text-end">

{{-- 📄 MENÚ PDF PRÓTESIS --}}
<div class="dropdown">

    <button class="btn btn-danger btn-sm dropdown-toggle"
            data-bs-toggle="dropdown">
        <i class="fa-solid fa-file-pdf me-1"></i>
        Prótesis PDF
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">

        {{-- 👁 VER --}}
        <li>
            <a class="dropdown-item"
               target="_blank"
               href="{{ route('protesis.timeline.pdf', $protesis) }}?view=1">
                <i class="fa-solid fa-eye me-2 text-primary"></i>
                Ver documento
            </a>
        </li>

        {{-- ⬇ DESCARGAR --}}
        <li>
            <a class="dropdown-item"
               href="{{ route('protesis.timeline.pdf', $protesis) }}">
                <i class="fa-solid fa-download me-2 text-success"></i>
                Descargar
            </a>
        </li>

    </ul>
</div>

                    </div>

                </div>
            </div>
            @endif
        @endforeach

        {{-- EMPTY STATE --}}
        @if(!$protesisActiva && $historialProtesis->count() === 0)
        <div class="text-center p-4">
            <i class="fa-solid fa-teeth-open fa-2x text-muted mb-2"></i>

            <div class="fw-semibold mb-1">
                Sin registros de prótesis
            </div>

            <div class="small text-muted mb-3">
                Inicie un nuevo tratamiento protésico para este paciente
            </div>

            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalNuevaProtesis">
                <i class="fa-solid fa-plus me-1"></i>
                Nueva prótesis
            </button>
        </div>
        @endif

    </div>
</div>


{{-- ================= MODAL NUEVA PRÓTESIS PREMIUM LIGERA ================= --}}
@if(!$protesisActiva)
<div class="modal fade" id="modalNuevaProtesis" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('protesis.store', $paciente->id) }}"
              class="modal-content border-0 shadow-sm rounded-3 overflow-hidden">
            @csrf

            {{-- HEADER --}}
            <div class="modal-header bg-primary bg-opacity-10 text-dark border-bottom">
                <h5 class="modal-title fw-semibold d-flex align-items-center gap-2">
                    <i class="fa-solid fa-teeth-open"></i>
                    Nueva Prótesis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body p-4 bg-white">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tipo *</label>
                        <select name="tipo" class="form-select border rounded shadow-sm" required>
                            <option disabled selected>Seleccionar</option>
                            <option value="superior">Superior</option>
                            <option value="inferior">Inferior</option>
                            <option value="completa">Completa</option>
                            <option value="parcial">Parcial</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Zona</label>
                        <select name="zona" class="form-select border rounded shadow-sm">
                            <option selected disabled>Seleccionar</option>
                            <option value="maxilar">Maxilar</option>
                            <option value="mandibula">Mandíbula</option>
                            <option value="bimaxilar">Bimaxilar</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha inicio *</label>
                        <input type="date" name="fecha_inicio" class="form-control border rounded shadow-sm" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Observaciones</label>
                        <textarea name="observaciones" class="form-control border rounded shadow-sm" rows="3" placeholder="Agregue notas o comentarios..."></textarea>
                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 bg-white pt-3 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-primary shadow-sm d-flex align-items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    Registrar
                </button>
            </div>

        </form>
    </div>
</div>
@endif


{{-- ================= MODAL FINALIZAR PRÓTESIS PREMIUM ================= --}}
@if($protesisActiva)
<div class="modal fade" id="modalFinalizarProtesis" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <form method="POST"
              action="{{ route('protesis.finalizar', $protesisActiva->id) }}"
              class="modal-content border-0 shadow-sm rounded-3 overflow-hidden">
            @csrf

            {{-- HEADER --}}
            <div class="modal-header bg-success bg-opacity-10 text-dark border-bottom">
                <h5 class="modal-title fw-semibold d-flex align-items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    Finalizar Prótesis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body p-4 bg-white">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Fecha finalización *</label>
                    <input type="date" name="fecha_termino" class="form-control border rounded shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Observaciones</label>
                    <textarea name="observaciones" class="form-control border rounded shadow-sm" rows="3" placeholder="Agregue notas o comentarios..."></textarea>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 bg-white pt-3 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-success shadow-sm d-flex align-items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    Finalizar
                </button>
            </div>

        </form>
    </div>
</div>
@endif



{{-- ================= MODAL SEGUIMIENTO PRÓTESIS PREMIUM LINEAL ================= --}}
@if($protesisActiva)
<div class="modal fade" id="modalSeguimientoProtesis" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- HEADER --}}
            <div class="modal-header bg-warning bg-opacity-25 text-dark border-bottom">
                <h5 class="modal-title fw-semibold d-flex align-items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Seguimiento clínico de prótesis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body p-4 bg-white">
                <div class="row g-4">

                    {{-- FORMULARIO NUEVO PASO --}}
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div class="card-body">

                                <h6 class="fw-semibold mb-3 text-secondary d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    Nuevo paso clínico
                                </h6>

                                <form method="POST" action="{{ route('protesis.seguimiento.store', $protesisActiva->id) }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Etapa clínica *</label>
                                        <select name="tipo_evento" class="form-select border rounded shadow-sm" required>
                                            <option disabled selected>Seleccionar</option>
                                            <option value="preparacion" class="text-warning">Preparación</option>
                                            <option value="impresion" class="text-primary">Impresión</option>
                                            <option value="provisional" class="text-info">Provisional</option>
                                            <option value="prueba" class="text-success">Prueba</option>
                                            <option value="ajuste" class="text-danger">Ajuste</option>
                                            <option value="cementacion" class="text-dark">Cementación</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Fecha *</label>
                                        <input type="date" name="fecha" class="form-control border rounded shadow-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Observaciones</label>
                                        <textarea name="descripcion" class="form-control border rounded shadow-sm" rows="3" placeholder="Agregue notas o comentarios..."></textarea>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-save"></i>
                                            Registrar paso
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- TIMELINE PREMIUM --}}
                    <div class="col-md-7 position-relative">

                        <ul class="timeline-premium list-unstyled m-0 p-0 position-relative">
                            @forelse($protesisActiva->seguimientos as $seguimiento)
                                @php
                                    $colorMap = [
                                        'preparacion' => 'warning',
                                        'impresion' => 'primary',
                                        'provisional' => 'info',
                                        'prueba' => 'success',
                                        'ajuste' => 'danger',
                                        'cementacion' => 'dark',
                                    ];
                                    $color = $colorMap[$seguimiento->tipo_evento] ?? 'secondary';
                                @endphp
                                <li class="mb-3 position-relative d-flex justify-content-start gap-3">
                                    {{-- Círculo en la línea --}}
                                    <span class="timeline-dot position-absolute top-0 start-50 translate-middle bg-{{ $color }} rounded-circle border border-white"></span>

                                    <div class="timeline-card bg-light border rounded shadow-sm p-2 ms-5 w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold text-{{ $color }}">{{ ucfirst($seguimiento->tipo_evento) }}</span>
                                            <small class="text-muted">{{ $seguimiento->fecha->format('d/m/Y') }}</small>
                                        </div>
                                        @if($seguimiento->descripcion)
                                            <div class="text-muted fst-italic small mt-1">
                                                Observaciones: {{ $seguimiento->descripcion }}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="text-muted fst-italic">No hay seguimientos registrados</li>
                            @endforelse
                        </ul>

                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 bg-white pt-3 d-flex justify-content-end">
                <button class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ESTILOS PREMIUM TIMELINE --}}
<style>
    .timeline-premium li {
        min-height: 60px;
    }
    .timeline-line {
        z-index: 0;
    }
    .timeline-dot {
        width: 16px;
        height: 16px;
        z-index: 1;
        top: 8px;
    }
    .timeline-card {
        position: relative;
        z-index: 2;
    }
    .timeline-card:hover {
        background-color: #f1f3f5;
        transition: 0.3s;
    }
</style>
@endif
