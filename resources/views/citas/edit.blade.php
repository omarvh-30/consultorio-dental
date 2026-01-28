@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="bi bi-calendar-check me-2 text-primary"></i>
                Editar Cita
            </h3>
            <div class="subtitle">Actualiza la información de la cita</div>
        </div>

        <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- ===== FORMULARIO ===== --}}
    <form action="{{ route('citas.update', $cita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-soft mb-4">
            {{-- Header homologado --}}
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-pencil-square me-1"></i> Datos de la cita
            </div>

            <div class="card-body">

                @include('citas.form')

                {{-- Botones finales --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save me-1"></i> Actualizar
                    </button>
                    <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </a>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
