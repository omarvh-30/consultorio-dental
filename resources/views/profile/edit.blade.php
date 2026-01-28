@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-user-gear me-2 text-primary"></i>
                Perfil de usuario
            </h3>
            <div class="text-muted">
                Administra tu información personal y seguridad
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        
    </div>

    {{-- ================= DATOS GENERALES ================= --}}
    <div class="card shadow-soft mb-4">

        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-person-badge me-1"></i>
            Datos generales
        </div>

        <div class="card-body">

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    Perfil actualizado correctamente.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="row g-3">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Ej: Juan Pérez">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Ej: correo@ejemplo.com">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-success shadow-sm px-4">
                        <i class="bi bi-save me-1"></i> Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ================= SEGURIDAD ================= --}}
    <div class="card shadow-soft">

        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-shield-lock me-1"></i>
            Seguridad de la cuenta
        </div>

        <div class="card-body">

            @if (session('status') === 'password-updated')
                <div class="alert alert-success">
                    Contraseña actualizada correctamente.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PATCH')

                <div class="row g-3">

                    {{-- Contraseña actual --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contraseña actual</label>
                        <input type="password"
                            name="current_password"
                            class="form-control"
                            placeholder="Ingrese su contraseña actual">
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nueva contraseña</label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Ingrese la nueva contraseña">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Confirmar contraseña</label>
                        <input type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Repita la nueva contraseña">
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-primary shadow-sm px-4">
                        <i class="bi bi-key me-1"></i> Actualizar contraseña
                    </button>
                </div>

            </form>
        </div>
    </div>


</div>

@endsection
