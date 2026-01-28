@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="fa-solid fa-calendar-days me-2 text-primary"></i>
                Agenda de Citas
            </h3>
            <div class="subtitle">Visualiza tus citas de forma mensual, semanal o diaria</div>
        </div>
    </div>

    {{-- ===== CALENDARIO ===== --}}
    <div class="card shadow-soft mb-4">
        {{-- Header homologado --}}
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-calendar-check me-1"></i> Calendario de Citas
        </div>

        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<style>
/* Rediseño premium de los botones de FullCalendar */
.fc-toolbar button {
    border-radius: 6px !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    font-weight: 500;
    margin-right: 4px;
    border: 1px solid #dee2e6;
    background-color: #fff;
    color: #0d6efd;
    transition: all 0.2s;
}

.fc-toolbar button:hover {
    background-color: #0d6efd;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Eventos con colores premium según estado */
.fc-event.programada {
    background-color: #ffc107 !important; /* Amarillo */
    color: #212529 !important;
    border: none !important;
}

.fc-event.atendida {
    background-color: #198754 !important; /* Verde */
    color: #fff !important;
    border: none !important;
}

.fc-event.cancelada {
    background-color: #dc3545 !important; /* Rojo */
    color: #fff !important;
    border: none !important;
}

.fc-event {
    border-radius: 6px !important;
    padding: 2px 6px !important;
    font-size: 0.85rem;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 'auto',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: '{{ route("citas.json") }}', // Devuelve array de citas con estado

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },

        eventClassNames: function(arg) {
            // Aplica clase según estado de la cita
            if (arg.event.extendedProps.estado === 'programada') {
                return ['programada'];
            } else if (arg.event.extendedProps.estado === 'atendida') {
                return ['atendida'];
            } else if (arg.event.extendedProps.estado === 'cancelada') {
                return ['cancelada'];
            }
        }
    });

    calendar.render();
});
</script>
@endpush
