@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-calendar-plus me-2 text-primary"></i>
                Nueva Cita
            </h3>
            <div class="subtitle">Registra una nueva cita para un paciente</div>
        </div>

        <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- ===== FORMULARIO ===== --}}
<form action="{{ route('citas.store') }}" method="POST">
    @csrf

    {{-- ===== DATOS DE LA CITA ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-calendar-check me-1"></i> Datos de la cita
        </div>

        <div class="card-body">
            <div class="row g-3">

                {{-- Paciente y Fecha/Hora en la misma fila --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Paciente *</label>
                    <select name="paciente_id"
                            class="form-select select-paciente"
                            required>
                        <option value="">Buscar paciente…</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}"
                                @selected(old('paciente_id') == $paciente->id)>
                                {{ $paciente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                
                    <label class="form-label fw-semibold">Fecha y hora *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-clock"></i>
                            </span>
                            <input type="datetime-local"
                                name="fecha_hora"
                                class="form-control"    
                                value="{{ old('fecha_hora') }}"
                                required>
                        </div>
                </div>

                {{-- Motivo en fila completa --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Motivo *</label>
                    <input type="text"
                           name="motivo"
                           placeholder="Ej. Limpieza, dolor, revisión…"
                           class="form-control"
                           value="{{ old('motivo') }}"
                           required>
                </div>

                {{-- Observaciones en fila completa --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Observaciones</label>
                    <textarea name="observaciones"
                              class="form-control"
                              placeholder="Notas adicionales para la cita…"
                              rows="3">{{ old('observaciones') }}</textarea>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== BOTONES ===== --}}
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Guardar
        </button>

        <a href="{{ route('citas.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg me-1"></i> Cancelar
        </a>
    </div>

</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select-paciente').select2({
        placeholder: 'Buscar paciente...',
        allowClear: true,
        width: '100%'
    });
});
</script>

@endsection
