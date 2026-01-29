
@extends('layouts.app')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-chart-line me-2 text-primary"></i>
                Panel Clínico
            </h3>
            <div class="subtitle">
                Control general del consultorio dental
            </div>
        </div>
    </div>
</div>

{{-- ================= ACCESOS RÁPIDOS SUPERIORES ================= --}}
<div class="container mb-6 animate-fade-in">
<div class="rounded-2xl card-surface
            border border-secondary-subtle
            shadow-[0_10px_30px_rgba(0,0,0,.08)]
            px-6 py-4">


        <div class="flex flex-wrap gap-4 justify-between">

            <a href="{{ route('pacientes.create') }}"
               class="flex items-center gap-3 px-5 py-3 rounded-xl border
                      transition hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow">
                <i class="fa-solid fa-user-plus text-blue-600 text-lg"></i>
                <span class="text-sm font-semibold">Nuevo paciente</span>
            </a>

            <a href="{{ route('citas.create.paciente') }}"
               class="flex items-center gap-3 px-5 py-3 rounded-xl border
                      transition hover:bg-indigo-50 hover:-translate-y-0.5 hover:shadow">
                <i class="fa-solid fa-calendar-plus text-indigo-600 text-lg"></i>
                <span class="text-sm font-semibold">Agendar cita</span>
            </a>

            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#modalBuscarPaciente"
               data-destino="odontograma"
               data-titulo="Seleccionar paciente – Odontograma"
               data-icono="fa-tooth"
               class="flex items-center gap-3 px-5 py-3 rounded-xl border
                      transition hover:bg-green-50 hover:-translate-y-0.5 hover:shadow">
                <i class="fa-solid fa-tooth text-green-600 text-lg"></i>
                <span class="text-sm font-semibold">Atención clínica</span>
            </a>

            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#modalBuscarPaciente"
               data-destino="expediente"
               data-titulo="Seleccionar paciente – Expediente clínico"
               data-icono="fa-file-medical"
               class="flex items-center gap-3 px-5 py-3 rounded-xl border
                      transition hover:bg-gray-100 hover:-translate-y-0.5 hover:shadow">
                <i class="fa-solid fa-file-medical text-gray-600 text-lg"></i>
                <span class="text-sm font-semibold">Expediente clínico</span>
            </a>

        </div>
    </div>
</div>

    {{-- ================= CONTENIDO ================= --}}
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- ================= CARDS RESUMEN ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- PACIENTES --}}
                <div class="relative rounded-2xl card-surface
                    border border-secondary-subtle
                    shadow-sm
                    p-6
                    overflow-hidden
                    transition hover:-translate-y-1 hover:shadow-md">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gray-400"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Pacientes</span>
                                <i class="fa-solid fa-users text-gray-300"></i>
                            </div>
                            <p class="text-4xl font-bold tracking-tight mt-4">
                                {{ $totalPacientes }}
                            </p>
                            <p class="text-xs uppercase tracking-wide text-gray-400 mt-1">
                                Registrados
                            </p>
                        </div>

                        {{-- CITAS HOY --}}
                        <div class="relative rounded-2xl card-surface
                    border border-secondary-subtle
                    shadow-sm
                    p-6
                    overflow-hidden
                    transition hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute top-0 left-0 w-full h-1 bg-blue-500"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Citas hoy</span>
                        <i class="fa-solid fa-calendar-check text-blue-400"></i>
                    </div>
                    <p class="text-4xl font-bold tracking-tight text-blue-600 mt-4">
                        {{ $citasHoyCount }}
                    </p>
                    <p class="text-xs uppercase tracking-wide text-gray-400 mt-1">
                        Agenda activa
                    </p>
                </div>

                {{-- PRÓXIMA CITA --}}
                <div class="relative rounded-2xl card-surface
                    border border-secondary-subtle
                    shadow-sm
                    p-6
                    overflow-hidden
                    transition hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gray-300"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Próxima cita</span>
                        <i class="fa-solid fa-clock text-gray-300"></i>
                    </div>

                    @if($proximaCita)
                        <p class="text-lg font-semibold mt-4">
                            {{ \Carbon\Carbon::parse($proximaCita->fecha_hora)->format('h:i A') }}
                        </p>
                        <p class="text-xs uppercase tracking-wide text-gray-400 mt-1">
                            {{ $proximaCita->paciente->nombre }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 mt-6">
                            Sin citas próximas
                        </p>
                    @endif
                </div>

                {{-- ORTODONCIA --}}
                <div class="relative rounded-2xl card-surface
                    border border-secondary-subtle
                    shadow-sm
                    p-6
                    overflow-hidden
                    transition hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute top-0 left-0 w-full h-1 bg-green-500"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Ortodoncia activa</span>
                        <i class="fa-solid fa-tooth text-green-400"></i>
                    </div>
                    <p class="text-4xl font-bold tracking-tight text-green-600 mt-4">
                        {{ $ortodonciaActiva }}
                    </p>
                    <p class="text-xs uppercase tracking-wide text-gray-400 mt-1">
                        En tratamiento
                    </p>
                </div>

            </div>


            {{-- ================= AGENDA + ALERTAS ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- AGENDA --}}
                <div class="md:col-span-2 card-surface rounded-2xl border border-gray-100 shadow-sm animate-fade-in">
                    <div class="px-6 py-4 border-b">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                            Agenda del día
                        </h3>
                    </div>

                    <div class="divide-y">

                        @forelse($citasHoy as $cita)

                        @php
                            $estadoUI = match($cita->estado) {
                                'programada' => [
                                    'dot'   => 'bg-yellow-500',
                                    'badge' => 'bg-yellow-100 text-yellow-700',
                                ],
                                'atendida' => [
                                    'dot'   => 'bg-green-500',
                                    'badge' => 'bg-green-100 text-green-700',
                                ],
                                'cancelada' => [
                                    'dot'   => 'bg-red-500',
                                    'badge' => 'bg-red-100 text-red-700',
                                ],
                                default => [
                                    'dot'   => 'bg-gray-400',
                                    'badge' => 'bg-gray-100 text-gray-600',
                                ],
                            };
                        @endphp

                        <div class="px-6 py-4 flex gap-4 items-start agenda-row transition">

                            {{-- Línea --}}
                            <div class="flex flex-col items-center">
                                <span class="w-3 h-3 rounded-full {{ $estadoUI['dot'] }} mt-1"></span>
                                <span class="w-px h-full bg-gray-200"></span>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <a href="{{ route('pacientes.odontograma', $cita->paciente->id) }}"
                                        class="text-decoration-none text-gray-600 hover:text-primary">
                                            {{ $cita->paciente->nombre }} · {{ $cita->motivo }}
                                        </a>
                                    </p>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ $estadoUI['badge'] }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </div>
                        </div>

                        @empty
                        <div class="px-6 py-6 text-center text-muted">
                            No hay citas registradas para hoy
                        </div>
                        @endforelse

                    </div>
                </div>
                {{-- ALERTAS CLÍNICAS --}}
                <div class="card-surface rounded-2xl border border-gray-100 shadow-sm
                            animate-fade-in [animation-delay:120ms]">

                    <div class="px-6 py-4 border-b">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                            <i class="fa-solid fa-bell text-red-500"></i>
                            Alertas clínicas
                        </h3>
                    </div>

                    <div class="px-6 py-4 space-y-3 text-sm">

                        {{-- 🔴 EVOLUCIÓN CLÍNICA PENDIENTE --}}
                        @foreach($alertasEvolucionPendiente as $alerta)
                            <div class="flex items-start gap-3 p-3 rounded-lg
                                        bg-red-50 hover:bg-red-100 transition
                                        animate-slide-in">

                                <i class="fa-solid fa-file-circle-exclamation text-red-600 mt-1"></i>

                                <a href="{{ route('evolucion.create', $alerta->id) }}"
                                class="text-decoration-none text-red-700">

                                    {{ $alerta->paciente->nombre }}

                                    <span class="block text-xs text-red-500">
                                        Evolución clínica pendiente
                                    </span>
                                </a>

                            </div>
                        @endforeach


                        {{-- 🟠 CITA PENDIENTE DE ATENDER --}}
                        @foreach($citasPendientesHoy as $cita)
                            <div class="flex items-start gap-3 p-3 rounded-lg
                                        bg-amber-50 hover:bg-amber-100 transition
                                        animate-slide-in [animation-delay:80ms]">

                                <i class="fa-solid fa-clock text-amber-600 mt-1"></i>

                                <a href="{{ route('citas.edit', $cita->id) }}"
                                class="text-decoration-none text-amber-700">

                                    {{ $cita->paciente->nombre }}

                                    <span class="block text-xs text-amber-500">
                                        Cita pendiente de atención
                                    </span>
                                </a>

                            </div>
                        @endforeach


                        {{-- ✅ SIN ALERTAS --}}
                        @if($alertasEvolucionPendiente->isEmpty() && $citasPendientesHoy->isEmpty())
                            <div class="text-center text-gray-400 py-6">
                                <i class="fa-solid fa-circle-check text-green-500 mb-2"></i>
                                <div>Sin alertas clínicas</div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- ================= ARENGLOS ABAJO ================= --}}
            <div >
            </div>
        </div>
    </div>

{{-- ================= ANIMACIONES ================= --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in .5s ease-out both;
}
.animate-slide-up {
    animation: slide-up .6s ease-out both;
}
</style>

{{-- ================= JS BUSCAR PACIENTE ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    let destinoActual = 'odontograma';

    const modal = document.getElementById('modalBuscarPaciente');
    const input = document.getElementById('buscarPaciente');
    const lista = document.getElementById('listaPacientes');
    const titulo = document.getElementById('tituloModal');
    const icono = document.getElementById('iconoModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const boton = event.relatedTarget;

        destinoActual = boton.getAttribute('data-destino');
        titulo.textContent = boton.getAttribute('data-titulo');

        icono.className = 'fa-solid me-2 ' + boton.getAttribute('data-icono');

        input.value = '';
        lista.innerHTML = `
            <div class="text-muted text-center py-3">
                Escribe para buscar pacientes
            </div>`;
    });

    input.addEventListener('keyup', function () {

        let query = this.value;

        if (query.length < 2) {
            lista.innerHTML = `
                <div class="text-muted text-center py-3">
                    Escribe al menos 2 letras
                </div>`;
            return;
        }

        fetch(`/buscar-pacientes?q=${query}`)
            .then(res => res.json())
            .then(data => {

                if (data.length === 0) {
                    lista.innerHTML = `
                        <div class="text-muted text-center py-3">
                            Sin resultados
                        </div>`;
                    return;
                }

                lista.innerHTML = '';

                data.forEach(paciente => {
                    lista.innerHTML += `
                        <a href="/pacientes/${paciente.id}/${destinoActual}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            ${paciente.nombre}
                            <i class="fa-solid fa-arrow-right text-muted"></i>
                        </a>`;
                });
            });
    });
});
</script>


{{-- ================= MODAL BUSCAR PACIENTE ================= --}}
<div class="modal fade" id="modalBuscarPaciente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    <i id="iconoModal" class="fa-solid fa-user me-2 text-primary"></i>
                    <span id="tituloModal">Seleccionar paciente</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="text"
                       id="buscarPaciente"
                       class="form-control mb-3"
                       placeholder="Buscar paciente por nombre...">

                <div id="listaPacientes"
                     class="list-group small"
                     style="max-height: 300px; overflow-y: auto;">
                    <div class="text-muted text-center py-3">
                        Escribe para buscar pacientes
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


@endsection