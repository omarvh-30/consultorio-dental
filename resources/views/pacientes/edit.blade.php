@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-tooth me-2 text-primary"></i>
                Editar Paciente
            </h3>
            <div class="subtitle">Actualiza la información del paciente</div>
        </div>

        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- ===== FORMULARIO ===== --}}
    <form action="{{ route('pacientes.update', $paciente) }}" method="POST">
        @csrf
        @method('PUT')

        @include('pacientes.form')

        {{-- Botones finales --}}
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary shadow-sm">
                <i class="bi bi-save me-1"></i> Actualizar
            </button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-x-lg me-1"></i> Cancelar
            </a>
        </div>
    </form>

</div>
@endsection
