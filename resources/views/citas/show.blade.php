@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-calendar-check me-2 text-primary"></i>
                Detalle de la Cita
            </h3>
            <div class="subtitle">Gestión de citas clínicas</div>
        </div>

        <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- ===== DATOS DE LA CITA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-calendar-check me-1"></i> Datos de la cita
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush ">
                <li class="list-group-item"><strong>Paciente:</strong> {{ $cita->paciente->nombre }}</li>
                <li class="list-group-item"><strong>Fecha / Hora:</strong> {{ date('d/m/Y H:i', strtotime($cita->fecha_hora)) }}</li>
                <li class="list-group-item"><strong>Motivo:</strong> {{ $cita->motivo }}</li>
                <li class="list-group-item">
                    <strong>Estado:</strong>
                    @if($cita->estado === 'programada')
                        <span class="badge bg-warning text-dark">Programada</span>
                    @elseif($cita->estado === 'atendida')
                        <span class="badge bg-success">Atendida</span>
                    @else
                        <span class="badge bg-danger">Cancelada</span>
                    @endif
                </li>
                <li class="list-group-item"><strong>Observaciones:</strong> {{ $cita->observaciones ?? 'Sin observaciones' }}</li>
            </ul>
        </div>
    </div>

    {{-- ===== EVOLUCIÓN EXISTENTE ===== --}}
    @if($cita->evolucion)

        {{-- Diagnóstico --}}
        <div class="card shadow-soft mb-4">
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-clipboard-check me-2"></i>
                Diagnóstico
            </div>
            <div class="card-body">
                <p>{{ $cita->evolucion->diagnostico }}</p>
            </div>
        </div>

        {{-- Procedimiento --}}
        <div class="card shadow-soft mb-4">
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-tools me-2"></i>
                Procedimiento
            </div>
            <div class="card-body">
                <p>{{ $cita->evolucion->procedimiento }}</p>
            </div>
        </div>

        {{-- Indicaciones --}}
        <div class="card shadow-soft mb-4">
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-info-circle me-2"></i>
                Indicaciones
            </div>
            <div class="card-body">
                <p>{{ $cita->evolucion->indicaciones ?? 'Sin indicaciones' }}</p>
            </div>
        </div>

        {{-- Firma del Paciente --}}
        <div class="card shadow-soft mb-4">
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-pencil-square me-2"></i>
                Consentimiento del Paciente
            </div>
            <div class="card-body text-center">
                <p class="fw-bold mb-3">Acepto tratamiento y evolución descrita</p>

                @if($cita->evolucion->firma)
                    <div class="firma-box mb-2">
                        <img src="{{ $cita->evolucion->firma->firma_base64 }}"
                             style="max-width:400px; border:1px solid #ccc; border-radius:6px;">
                    </div>

                    <small class="text-muted">
                        Firmado el: {{ $cita->evolucion->firma->created_at->format('d/m/Y H:i') }}
                    </small>
                @else
                    <span class="badge bg-warning shadow-sm">
                        ⚠ Esta evolución NO tiene firma del paciente
                    </span>
                @endif
            </div>
        </div>

    @else
        {{-- Registrar evolución si la cita ya fue atendida --}}
        @if($cita->estado === 'atendida')
            <a href="{{ route('evolucion.create', $cita) }}" class="btn btn-success shadow-sm mb-4">
                <i class="bi bi-file-medical me-1"></i> Registrar Historia Clínica
            </a>
        @endif
    @endif

</div>

<style>
.firma-box {
    background: #fafafa;
    padding: 10px;
    border-radius: 6px;
    display: inline-block;
}
</style>
@endsection
