@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-notes-medical me-2 text-primary"></i>
                Historia Clínica
            </h3>
            <div class="subtitle">Registro clínico completo del paciente</div>
        </div>

        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- ===== DATOS GENERALES ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-person-badge me-1"></i> Datos generales
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <strong>Nombre:</strong><br>
                    {{ $paciente->nombre }}
                </div>

                <div class="col-md-3">
                    <strong>Sexo:</strong><br>
                    {{ $paciente->sexo ?? '—' }}
                </div>
                
                <div class="col-md-3">
                    <strong>Fecha de nacimiento:</strong><br>
                    {{ $paciente->fecha_nacimiento
                        ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y')
                        : '—' }}
                </div>

                <div class="col-md-3">
                    <strong>Tipo de sangre:</strong><br>
                    {{ $paciente->tipo_sangre ?? '—' }}
                </div>

                <div class="col-md-3">
                    <strong>Teléfono:</strong><br>
                    {{ $paciente->telefono ?? '—' }}
                </div>

                <div class="col-md-3">
                    <strong>Email:</strong><br>
                    {{ $paciente->email ?? '—' }}
                </div>

<div class="col-md-3">
    <strong>Tipo de paciente:</strong><br>

    @if($paciente->es_ortodoncia || $paciente->es_protesis)

        @if($paciente->es_ortodoncia)
            <span class="badge bg-primary me-1">
                <i class="fa-solid fa-tooth me-1"></i> Ortodoncia
            </span>
        @endif

        @if($paciente->es_protesis)
            <span class="badge bg-warning text-dark">
                <i class="fa-solid fa-teeth-open me-1"></i> Prótesis
            </span>
        @endif

    @else
        <span class="badge bg-secondary">
            <i class="fa-solid fa-user me-1"></i> General
        </span>
    @endif
</div>


            </div>
        </div>
    </div>

    {{-- ===== HISTORIA MÉDICA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-heart-pulse me-1"></i> Historia médica
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <strong>Alergias:</strong><br>
                    {{ $paciente->alergias ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Antecedentes heredofamiliares:</strong><br>
                    {{ $paciente->antecedentes_heredofamiliares ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Antecedentes patológicos:</strong><br>
                    {{ $paciente->antecedentes_patologicos ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Antecedentes no patológicos:</strong><br>
                    {{ $paciente->antecedentes_no_patologicos ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Tratamiento médico / medicamentos:</strong><br>
                    {{ $paciente->tratamiento_medico ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Enfermedades relevantes:</strong><br>
                    {{ $paciente->enfermedades ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Traumatismos:</strong><br>
                    {{ $paciente->traumatismos ?: '—' }}
                </div>

                <div class="col-md-6">
                    <strong>Transfusiones / cirugías:</strong><br>
                    {{ $paciente->transfusiones_cirugias ?: '—' }}
                </div>

            </div>
        </div>
    </div>

    {{-- ===== HISTORIAL DE CITAS ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-calendar-check me-1"></i> Historial de citas
        </div>
        <div class="card-body">

            @forelse($paciente->citas as $cita)
                <div class="card shadow-sm mb-3">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-clock me-1"></i>
                            {{ date('d/m/Y H:i', strtotime($cita->fecha_hora)) }}
                        </span>

                        <span class="badge
                            @if($cita->estado == 'atendida') bg-success
                            @elseif($cita->estado == 'programada') bg-warning text-dark
                            @else bg-danger
                            @endif">
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </div>

                    <div class="card-body">
                        <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>

                        @if($cita->evolucion)
                            <hr>
                            <p><strong>Diagnóstico:</strong><br>
                                {{ $cita->evolucion->diagnostico }}</p>

                            <p><strong>Procedimiento:</strong><br>
                                {{ $cita->evolucion->procedimiento }}</p>

                            <p><strong>Indicaciones:</strong><br>
                                {{ $cita->evolucion->indicaciones }}</p>
                        @else
                            <div class="alert alert-secondary mb-0">
                                No hay registro clínico para esta cita.
                            </div>
                        @endif
                    </div>

                </div>
            @empty
                <div class="alert alert-info mb-0">
                    Este paciente aún no tiene citas registradas.
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection
