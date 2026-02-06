@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-tooth me-2 text-primary"></i>
                Detalle del Paciente
            </h3>
            <div class="subtitle">Información clínica completa</div>
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

    {{-- ===== INFORMACIÓN MÉDICA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-heart-pulse me-1"></i> Información médica
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

    {{-- ===== MOTIVO DE CONSULTA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-chat-left-text me-1"></i> Motivo de consulta
        </div>
        <div class="card-body">
            {{ $paciente->motivo_consulta ?: '—' }}
        </div>
    </div>

    {{-- ===== CONTACTO DE EMERGENCIA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-telephone-forward me-1"></i> Contacto de emergencia
        </div>
        <div class="card-body">
            <strong>Nombre:</strong>
            {{ $paciente->contacto_emergencia ?? '—' }} <br>

            <strong>Teléfono:</strong>
            {{ $paciente->telefono_emergencia ?? '—' }}
        </div>
    </div>

</div>
@endsection
