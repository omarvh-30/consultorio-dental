@extends('layouts.app')
@vite(['resources/js/odontograma.js'])
@php
    $plan = $planActivo;
@endphp

@section('content')
<div class="container py-4">

{{-- ===== HEADER ===== --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="header-title mb-0">
            <i class="fa-solid fa-tooth me-2 text-primary"></i>
            Odontograma – {{ strtoupper($paciente->nombre) }}
        </h3>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

</div>

{{-- ===== ALERTAS GLOBALES (NUEVO) ===== --}}
@if(session('error'))
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex align-items-start">

        <i class="fa-solid fa-circle-xmark text-danger fa-lg me-3 mt-1"></i>

        <div>
            <div class="fw-semibold text-danger">
                Ocurrió un problema
            </div>

            <div class="small text-muted">
                {{ session('error') }}
            </div>
        </div>

    </div>
</div>
@endif


@if(session('success'))
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex align-items-start">

        <i class="fa-solid fa-circle-check text-success fa-lg me-3 mt-1"></i>

        <div>
            <div class="fw-semibold text-success">
                Operación realizada correctamente
            </div>

            <div class="small text-muted">
                {{ session('success') }}
            </div>
        </div>

    </div>
</div>
@endif




{{-- ===== BADGE PACIENTE ORTODONCIA ===== --}}
@if($paciente->es_ortodoncia == 1)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex align-items-center">

        <div class="me-3">
            <i class="fa-solid fa-tooth fa-2x text-primary"></i>
        </div>

        <div class="flex-grow-1">
            <div class="fw-semibold">
                Paciente en tratamiento de ortodoncia
            </div>

            <div class="small text-muted mt-1 d-flex align-items-center flex-wrap gap-2">
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                    Tratamiento activo
                </span>

                <span>
                    Seguimiento clínico desde la pestaña de ortodoncia
                </span>
            </div>
        </div>

    </div>
</div>

@endif



{{-- =========================
     SECCIÓN FIJA: ODONTOGRAMA PREMIUM
========================== --}}

<div class="card border-0 shadow-sm mb-4">

{{-- 🔹 HEADER PREMIUM --}}
<div class="card-header bg-gradient border-0"
     style="background: linear-gradient(45deg,#0d6efd,#0dcaf0);">

    <div class="d-flex justify-content-between align-items-center">

        <div class="text-white">
            <h5 class="mb-0">
                <i class="fa-solid fa-teeth-open me-2"></i>
                Odontograma Clínico
            </h5>

            <small class="opacity-75">
                Registro gráfico del estado dental
            </small>
        </div>

        <button type="button"
            class="btn btn-light btn-sm rounded-circle"
            data-bs-toggle="popover"
            data-bs-html="true"
            data-bs-placement="left"
            data-bs-content="
            <strong>Instrucciones:</strong><br>
            • Haga clic sobre un diente<br>
            • Seleccione el estado clínico<br>
            • Agregue observación opcional<br>
            • El historial se guarda automáticamente
            ">
            <i class="fa-solid fa-question"></i>
        </button>

    </div>
</div>

<div class="card-body bg-light bg-opacity-25">

    <div class="text-center p-2 bg-white rounded shadow-sm">
        @include('odontograma.svg', ['paciente' => $paciente])
    </div>

    {{-- 🔹 LEYENDA PROFESIONAL --}}
    <div class="mt-3">
        <div class="text-muted small mb-2">
            <i class="fa-solid fa-circle-info me-1"></i>
            Estados del diente
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <span class="badge bg-success px-3 py-2">
                <i class="fa-solid fa-check me-1"></i> Sano
            </span>
            <span class="badge bg-danger px-3 py-2">
                <i class="fa-solid fa-virus me-1"></i> Caries
            </span>
            <span class="badge bg-primary px-3 py-2">
                <i class="fa-solid fa-fill-drip me-1"></i> Obturado
            </span>
            <span class="badge bg-warning text-dark px-3 py-2">
                <i class="fa-solid fa-bandage me-1"></i> Endodoncia
            </span>
            <span class="badge bg-secondary px-3 py-2">
                <i class="fa-solid fa-xmark me-1"></i> Extraído
            </span>
        </div>
    </div>

</div>
</div>


{{-- =========================
        TABS INFERIORES
========================== --}}

<ul class="nav nav-tabs tabs-premium border-0">

<li class="nav-item">
<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#historia">
<i class="fa-solid fa-clock-rotate-left me-1"></i>
Historia Odontológica
</button>
</li>

<li class="nav-item">
<button class="nav-link" data-bs-toggle="tab" data-bs-target="#plan">
<i class="fa-solid fa-list-check me-1"></i>
Plan de Tratamiento
</button>
</li>

<li class="nav-item">
<button class="nav-link" data-bs-toggle="tab" data-bs-target="#pagos">
<i class="fa-solid fa-money-bill me-1"></i>
Pagos
</button>
</li>

<li class="nav-item">
<button class="nav-link" data-bs-toggle="tab" data-bs-target="#planes">
<i class="fa-solid fa-folder-open me-1"></i>
Planes Anteriores
</button>
@if($paciente->es_ortodoncia == 1)
</li>
<li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ortodoncia">
        <i class="fa-solid fa-tooth me-1"></i>
        Ortodoncia
    </button>
</li>
@endif
</ul>

<div class="tab-content tab-content-premium p-3">

{{-- ========= TAB 1 : HISTORIA PREMIUM ========= --}}
<div class="tab-pane fade show active" id="historia">

{{-- 🔹 RESUMEN SUPERIOR --}}
<div class="row g-3 mb-3">

    <div class="col-12 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-2">
                <div class="text-muted small">Total Registros</div>
                <h5 class="fw-bold mb-0">
                    {{ $historiaOdonto->count() }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <input id="filtroDiente"
        class="form-control"
        placeholder="🔍 Filtrar por diente, estado u observación...">
    </div>

</div>


{{-- 🔹 TIMELINE + TABLA --}}
<div class="card border-0 shadow-sm">
<div class="card-header bg-info bg-opacity-25 py-2">
<div class="d-flex justify-content-between align-items-center">

    <div>
        <i class="fa-solid fa-tooth me-1"></i>
        Historia Odontológica
    </div>

    {{-- 🧾 MENÚ PDF EXPEDIENTE --}}
    <div class="dropdown">

        <button class="btn btn-danger btn-sm dropdown-toggle"
                data-bs-toggle="dropdown">

            <i class="fa-solid fa-file-pdf me-1"></i>
            Expediente PDF
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">

            {{-- 👁 VER --}}
            <li>
                <a class="dropdown-item"
                   target="_blank"
                   href="{{ route('pacientes.odontograma.pdf', $paciente->id) }}?view=1">

                    <i class="fa-solid fa-eye me-2 text-primary"></i>
                    Ver documento
                </a>
            </li>

            {{-- ⬇ DESCARGAR --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route('pacientes.odontograma.pdf', $paciente->id) }}">

                    <i class="fa-solid fa-download me-2 text-success"></i>
                    Descargar
                </a>
            </li>
        </ul>

    </div>

</div>
</div>


<div class="card-body p-0">

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">

<thead class="bg-light small">
<tr>
    <th class="ps-3">Fecha</th>
    <th>Diente</th>
    <th>Estado</th>
    <th>Observaciones</th>
</tr>
</thead>

<tbody>

@forelse($historiaOdonto as $h)

<tr class="fila-historia"
    data-diente="{{ $h->diente }}"
    data-estado="{{ $h->estado }}"
    data-obs="{{ $h->observaciones }}"
    style="cursor:pointer;">

<td class="ps-3">
    <div class="small fw-bold">
        {{ $h->created_at->format('d/m/Y') }}
    </div>
    <div class="text-muted" style="font-size:11px">
        {{ $h->created_at->format('H:i') }}
    </div>
</td>

<td>
    <span class="badge bg-secondary fs-6">
        {{ $h->diente }}
    </span>
</td>

<td>
    @include('pacientes.partials.estado-badge',
    ['estado'=>$h->estado])
</td>

<td class="small text-muted">
    {{ $h->observaciones ?? '—' }}
</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center py-4">
    <i class="fa-solid fa-notes-medical fs-1 text-muted mb-2"></i>
    <p class="text-muted mb-0">
        No hay registros en la historia odontológica
    </p>
</td>
</tr>

@endforelse

</tbody>
</table>
</div>

</div>
</div>

</div>



{{-- ========= MODAL ========= --}}
<div class="modal fade" id="modalDiente">
<div class="modal-dialog">
<div class="modal-content">

<form id="formDiente" method="POST"
action="{{ route('odontograma.guardar') }}">
@csrf

<input type="hidden" name="paciente_id"
value="{{ $paciente->id }}">

<input type="hidden" name="diente"
id="inputDiente">

<div class="modal-header bg-primary text-white">
<h5>Diente:
<span id="dienteSeleccionado"></span>
</h5>
</div>

<div class="modal-body">

<select id="estadoDiente" name="estado" class="form-select">

<option value="sano">Sano</option>
<option value="caries">Caries</option>
<option value="obturado">Obturado</option>
<option value="endodoncia">Endodoncia</option>
<option value="extraido">Extraído</option>

</select>

<textarea id="observacionesDiente"
name="observaciones"
class="form-control mt-2"
placeholder="Observaciones"></textarea>

</div>

<div class="modal-footer">
<button class="btn btn-primary">
Guardar
</button>
</div>

</form>

</div>
</div>
</div>


{{-- ========= TAB 2 : PLAN PREMIUM ========= --}}
<div class="tab-pane fade" id="plan">

@if(!$plan)

    {{-- ===================== SIN PLAN ===================== --}}
    @if(count($dientesPlan) == 0)

<div class="card border-0 shadow-sm text-center p-4">
    <i class="fa-solid fa-tooth fa-2x text-primary mb-2"></i>
    <div class="fw-semibold">Plan de tratamiento no generado</div>
    <div class="small text-muted mt-1">
        Seleccione en el odontograma dientes con estado
        <strong>caries, obturado o endodoncia</strong>
        para crear el plan.
    </div>
</div>

    @else

    {{-- ===================== CREAR PLAN ===================== --}}

    <form method="POST" action="{{ route('plan.guardar') }}">
    @csrf

    <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">

            <div>
                <h6 class="mb-0">
                    <i class="fa-solid fa-list-check me-1"></i>
                    Configuración del plan
                </h6>
                <small class="text-muted">
                    Asigne tratamiento y precio a cada diente
                </small>
            </div>

            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Guardar Plan
            </button>

        </div>
    </div>

    <div class="row g-3">

    @foreach($dientesPlan as $diente => $estado)

    <div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100 border-0 shadow-sm hover-card">

        <div class="card-header py-2">

            <div class="d-flex justify-content-between align-items-center">

                <span class="fw-bold">
                    <i class="fa-solid fa-tooth me-1"></i>
                    {{ $diente }}
                </span>

                @include('pacientes.partials.estado-badge',
                ['estado'=>$estado])

            </div>

        </div>

        <div class="card-body">

            <label class="small text-muted">Tratamiento</label>

            <select name="items[{{ $diente }}][tratamiento]"
                class="form-select mb-2 tratamiento">

                <option value="">Seleccione</option>

                @foreach($catalogo[$estado] ?? [] as $opcion)
                <option value="{{ $opcion->nombre }}">
                    {{ $opcion->nombre }}
                </option>
                @endforeach

            </select>

            <label class="small text-muted">Precio</label>

            <input name="items[{{ $diente }}][precio_paciente]"
                class="form-control precio"
                placeholder="0.00">

        </div>

    </div>
    </div>

    @endforeach

    </div>

    </form>

    @endif



{{-- ===================== PLAN EXISTENTE ===================== --}}
@else

{{-- 🔹 HEADER + PROGRESO UNIFICADO --}}
@php
$totalItems = $plan->items->count();
$terminados = $plan->items->where('estatus','terminado')->count();

$avance = $totalItems > 0
    ? round(($terminados * 100) / $totalItems)
    : 0;
@endphp

<div class="card border-0 shadow-sm mb-3">

<div class="card-body py-2">

<div class="d-flex justify-content-between align-items-center mb-2">

    <div>
        <h6 class="mb-0">
            <i class="fa-solid fa-file-medical me-1 text-primary"></i>
            Plan de Tratamiento
        </h6>

        <small class="text-muted">
            Progreso del tratamiento del paciente
        </small>
    </div>

    <div class="d-flex gap-2">

    @if($plan->aceptado)

<span class="badge bg-success">
    <i class="fa-solid fa-file-signature me-1"></i>
    Aceptado el {{ $plan->fecha_aceptacion->format('d/m/Y') }}
</span>

@else

<span class="badge bg-warning text-dark">
    <i class="fa-solid fa-triangle-exclamation me-1"></i>
    Pendiente de aceptación
</span>

@endif


        @if(!$plan->aceptado)

        <button class="btn btn-success btn-sm"
                onclick="new bootstrap.Modal(document.getElementById('modalFirmaPlan')).show()">

            <i class="fa-solid fa-pen me-1"></i>
            Aceptar plan
        </button>

        @else

        <span class="badge bg-success">
            <i class="fa-solid fa-check me-1"></i>
            Plan aceptado
        </span>

        @endif


        {{-- 🔴 BOTÓN PDF PLAN --}}
        <div class="dropdown">

            <button class="btn btn-danger btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown">

                <i class="fa-solid fa-file-pdf me-1"></i>
                Plan PDF
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">

                <li>
                    <a class="dropdown-item"
                       target="_blank"
                       href="{{ route('pacientes.plan.pdf', $paciente->id) }}?view=1">

                        <i class="fa-solid fa-eye me-2 text-primary"></i>
                        Ver documento
                    </a>
                </li>

                <li>
                    <a class="dropdown-item"
                       href="{{ route('pacientes.plan.pdf', $paciente->id) }}">

                        <i class="fa-solid fa-download me-2 text-success"></i>
                        Descargar
                    </a>
                </li>

            </ul>

        </div>

        {{-- BADGE PROGRESO --}}
        <span class="badge bg-light text-dark border">
            {{ $terminados }} / {{ $totalItems }} completados
        </span>

    </div>

</div>


    {{-- Barra de progreso --}}
    <div class="d-flex justify-content-between small mb-1">
        <span>Avance total</span>
        <span class="fw-bold">{{ $avance }}%</span>
    </div>

    <div class="progress" style="height:8px">
        <div class="progress-bar bg-success"
             style="width:{{ $avance }}%">
        </div>
    </div>
    @if(
    $plan->aceptado &&
    $terminados == $totalItems &&
    $totalItems > 0 &&
    $plan->saldo == 0
    )
    <form method="POST" action="{{ route('plan.finalizar') }}" class="mt-3">
    @csrf

    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

    <button class="btn btn-danger w-100">
    <i class="fa-solid fa-flag-checkered me-1"></i>
    Finalizar Tratamiento
    </button>

    </form>

    @endif


</div>
</div>


{{-- 🔹 RESUMEN FINANCIERO (GRID 4) --}}
<div class="row mb-3 g-3">

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<div class="small text-muted">Total</div>

<div class="fs-5 fw-bold text-primary">
${{ number_format($plan->total,2) }}
</div>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<div class="small text-muted">Pagado</div>

<div class="fs-5 fw-bold text-success">
${{ number_format($plan->pagado,2) }}
</div>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<div class="small text-muted">Saldo</div>

<div class="fs-5 fw-bold text-danger">
${{ number_format($plan->saldo,2) }}
</div>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body d-flex align-items-center">

@if($plan->aceptado)
<button class="btn btn-success w-100"
onclick="new bootstrap.Modal(document.getElementById('modalPago')).show()">
@endif

<i class="fa-solid fa-money-bill me-1"></i>
Registrar Pago

</button>

</div>
</div>
</div>

</div>





{{-- 🔹 TARJETAS POR DIENTE --}}
<div class="row g-3">

@foreach($plan->items as $item)

<div class="col-12 col-md-6 col-lg-3">

<div class="card h-100 border-0 shadow-sm hover-card">

<div class="card-header py-2">

<div class="d-flex justify-content-between">

<span class="fw-bold">
{{ $item->diente }}
</span>

@if($item->estatus == 'terminado')
<span class="badge bg-success">Terminado</span>
@else
<span class="badge bg-warning">Pendiente</span>
@endif

</div>

</div>

<div class="card-body">

<div class="fw-bold mb-1">
{{ $item->tratamiento }}
</div>

<div class="text-primary mb-2">
${{ number_format($item->precio_paciente,2) }}
</div>


@if($plan->aceptado && $item->estatus != 'terminado')

<form method="POST"
action="{{ route('plan.item.terminar') }}">
@csrf

<input type="hidden"
name="item_id"
value="{{ $item->id }}">

<button class="btn btn-sm btn-outline-success w-100">
<i class="fa-solid fa-check me-1"></i>
Terminar tratamiento
</button>

</form>

@endif

</div>

</div>

</div>

@endforeach

</div>


@endif

</div>



@if($plan)
{{-- ===== MODAL FIRMA ===== --}}
<div class="modal fade" id="modalFirmaPlan">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form id="formFirmaPlan" method="POST"
      action="{{ route('plan.aceptar') }}">
@csrf

<input type="hidden" name="plan_id" value="{{ $plan->id }}">

<div class="modal-header bg-success text-white">
<h5 class="modal-title">
<i class="fa-solid fa-file-signature me-1"></i>
Aceptación del Plan de Tratamiento
</h5>
</div>

<div class="modal-body">

<p class="small text-muted">
El paciente declara haber recibido información clara sobre el plan
de tratamiento propuesto y acepta voluntariamente su realización.
</p>

<div class="border rounded p-2 text-center">
    <canvas id="canvasFirmaPlan"
            style="border:1px solid #ccc; border-radius:6px; width:100%; height:250px;">
    </canvas>
</div>

<button type="button"
        class="btn btn-warning btn-sm mt-2"
        id="limpiarFirmaPlan">
    <i class="fa-solid fa-trash me-1"></i>
    Limpiar firma
</button>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary"
        data-bs-dismiss="modal">
Cancelar
</button>

<button type="button" class="btn btn-success"
        id="guardarFirmaPlan">
<i class="fa-solid fa-check me-1"></i>
Aceptar y firmar
</button>
</div>

</form>

</div>
</div>
</div>

@endif


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
let signaturePadPlan;
let modalFirmaPlan = document.getElementById('modalFirmaPlan');

if (modalFirmaPlan) {

    modalFirmaPlan.addEventListener('shown.bs.modal', () => {
        const canvas = document.getElementById('canvasFirmaPlan');
        canvas.width = canvas.offsetWidth;
        canvas.height = 250;
        signaturePadPlan = new SignaturePad(canvas);
    });

    document.getElementById('limpiarFirmaPlan')
        .addEventListener('click', () => {
            signaturePadPlan.clear();
        });

    document.getElementById('guardarFirmaPlan')
        .addEventListener('click', () => {

            if (signaturePadPlan.isEmpty()) {
                alert('⚠ La firma del paciente es obligatoria');
                return;
            }

            const form = document.getElementById('formFirmaPlan');

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'firma_paciente'; // ✅ CORRECTO
            input.value = signaturePadPlan.toDataURL('image/png');

            form.appendChild(input);
            form.submit();
        });
}
</script>
@endpush


@if($plan)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const modalPago = document.getElementById('modalPago');
    if (!modalPago) return;

    const formPago = modalPago.querySelector('form');
    const montoInput = document.getElementById('montoPago');
    const saldo = {{ $plan->saldo }};

    formPago.addEventListener('submit', function (e) {

        const monto = parseFloat(montoInput.value || 0);

        if (monto <= 0) {
            alert('⚠ El monto debe ser mayor a cero');
            montoInput.focus();
            e.preventDefault();
            return;
        }

        if (monto > saldo) {
            alert('⚠ El monto no puede ser mayor al saldo pendiente ($' + saldo.toFixed(2) + ')');
            montoInput.focus();
            e.preventDefault();
            return;
        }
    });

});
</script>
@endpush
@endif













{{-- ========= TAB 3 : PAGOS PREMIUM ========= --}}
<div class="tab-pane fade" id="pagos">

@if($plan)
{{-- 🔹 RESUMEN FINANCIERO --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm payment-kpi">
            <div class="label">Total del plan</div>
            <div class="value text-primary">
                ${{ number_format($plan->total, 2) }}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm payment-kpi">
            <div class="label">Monto pagado</div>
            <div class="value text-success">
                ${{ number_format($plan->pagos->sum('monto'), 2) }}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm payment-kpi">
            <div class="label">Saldo pendiente</div>
            <div class="value text-danger">
                ${{ number_format($plan->saldo, 2) }}
            </div>
        </div>
    </div>

</div>

    {{-- 🔹 TABLA PREMIUM DE PAGOS --}}
    <div class="card border-0 shadow-sm">
 <div class="card-header bg-white py-3">
    <div class="payment-header">
        <div>
            <div class="fw-semibold">
                <i class="fa-solid fa-clock me-1 text-primary"></i>
                Historial de pagos
            </div>
            <div class="small text-muted">
                Movimientos financieros del plan activo
            </div>
        </div>
    </div>
</div>

        <div class="card-body p-0">

@if($plan->pagos->count() == 0)

<div class="payment-empty text-center">
    <i class="fa-solid fa-receipt fa-2x text-muted mb-2"></i>
    <div class="fw-semibold">Sin pagos registrados</div>
    <div class="small text-muted">
        Los pagos realizados aparecerán aquí automáticamente
    </div>
</div>

@else


<div class="table-responsive">
<table class="table table-hover align-middle mb-0 table-payments">

    <thead class="bg-light">
        <tr>
            <th class="ps-3">Fecha</th>
            <th>Monto</th>
            <th>Método</th>
            <th>Nota</th>
        </tr>
    </thead>

    <tbody>

    @foreach($plan->pagos->sortByDesc('created_at') as $p)
    <tr>

        <td class="ps-3">
            <div class="fw-semibold">
                {{ $p->created_at->format('d/m/Y') }}
            </div>
            <div class="text-muted small">
                {{ $p->created_at->format('H:i') }}
            </div>
        </td>

        <td class="fw-bold text-success">
            ${{ number_format($p->monto, 2) }}
        </td>

        <td>
            @php
                $color = match($p->metodo) {
                    'Efectivo' => 'success',
                    'Tarjeta' => 'primary',
                    'Transferencia' => 'info',
                    default => 'secondary'
                };
            @endphp

            <span class="badge rounded-pill bg-{{ $color }}">
                {{ $p->metodo }}
            </span>
        </td>

        <td class="text-muted small">
            {{ $p->nota ?? '—' }}
        </td>

    </tr>
    @endforeach

    </tbody>
</table>
</div>
@endif


        </div>
    </div>

@else

<div class="card border-0 shadow-sm text-center p-4">
    <i class="fa-solid fa-lock fa-2x text-warning mb-2"></i>
    <div class="fw-semibold">Pagos no disponibles</div>
    <div class="small text-muted mt-1">
        Para registrar pagos es necesario que el plan de tratamiento
        esté generado y aceptado.
    </div>
</div>

@endif

</div>



{{-- ===== MODAL PAGOS ===== --}}
@if($plan)
<div class="modal fade" id="modalPago">
<div class="modal-dialog">
<div class="modal-content">

<form method="POST" action="{{ route('plan.pago') }}">
@csrf

<input type="hidden" name="plan_id" value="{{ $plan->id }}">

<div class="modal-header bg-success text-white">
<h5 class="modal-title">
<i class="fa-solid fa-cash-register me-1"></i>
Registrar Pago
</h5>
</div>

<div class="modal-body">

<label class="small text-muted">Monto</label>
<input name="monto" id="montoPago" class="form-control mb-2" required>

<label class="small text-muted">Método</label>
<select name="metodo" class="form-select mb-2">
<option>Efectivo</option>
<option>Tarjeta</option>
<option>Transferencia</option>
</select>

<label class="small text-muted">Nota</label>
<textarea name="nota" class="form-control"></textarea>

</div>

<div class="modal-footer">
<button class="btn btn-success">
Guardar Pago
</button>
</div>

</form>

</div>
</div>
</div>
@endif















{{-- ========= TAB 4 : HISTORIAL ========= --}}
<div class="tab-pane fade" id="planes">
@if($planes->count() == 0)

<div class="card border-0 shadow-sm text-center p-4">
    <i class="fa-solid fa-folder-open fa-2x text-secondary mb-2"></i>
    <div class="fw-semibold">Sin registros disponibles</div>
    <div class="small text-muted mt-1">
        Aún no existen registros para mostrar en esta sección.
    </div>
</div>

@else

@foreach($planes as $p)

<div class="card border-0 shadow-sm mb-4">

    {{-- HEADER --}}
    @php
        $color = match($p->estatus) {
            'pendiente' => 'secondary',
            'aceptado' => 'warning',
            'en_proceso' => 'primary',
            'finalizado' => 'success',
            default => 'dark'
        };
    @endphp

    <div class="card-body pb-2">

        <div class="plan-header mb-3">

            <div>
                <div class="fw-semibold">
                    <i class="fa-solid fa-file-medical me-1 text-primary"></i>
                    Plan #{{ $p->id }}
                </div>
                <div class="plan-meta">
                    Creado el {{ $p->created_at->format('d/m/Y') }}
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-plan bg-{{ $color }}">
                    {{ strtoupper(str_replace('_',' ', $p->estatus)) }}
                </span>

                <a target="_blank"
                   href="{{ route('pacientes.plan.pdf', $paciente->id) }}?plan={{ $p->id }}"
                   class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                
            </div>

        </div>

        {{-- KPIs --}}
        <div class="row g-3 mb-3">

            <div class="col-md-4">
                <div class="plan-kpi">
                    <div class="label">Total del plan</div>
                    <div class="value">
                        ${{ number_format($p->total,2) }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="plan-kpi">
                    <div class="label">Pagado</div>
                    <div class="value text-success">
                        ${{ number_format($p->pagado,2) }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="plan-kpi">
                    <div class="label">Saldo</div>
                    <div class="value text-danger">
                        ${{ number_format($p->saldo,2) }}
                    </div>
                </div>
            </div>

        </div>

        {{-- ITEMS --}}
        <div class="table-responsive mb-3">
            <table class="table table-sm table-hover align-middle">

                <thead class="bg-light">
                <tr>
                    <th>Diente</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Estatus</th>
                </tr>
                </thead>

                <tbody>
                @foreach($p->items as $i)
                <tr>
                    <td class="fw-semibold">{{ $i->diente }}</td>
                    <td>{{ $i->tratamiento }}</td>
                    <td>${{ number_format($i->precio_paciente,2) }}</td>
                    <td>
                        <span class="badge bg-{{ $i->estatus == 'terminado' ? 'success' : 'warning' }}">
                            {{ ucfirst($i->estatus) }}
                        </span>
                    </td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        {{-- PAGOS --}}
        @if($p->pagos->count())
        <hr>

        <div class="fw-semibold mb-2">
            <i class="fa-solid fa-money-bill text-success me-1"></i>
            Historial de pagos
        </div>

        <div class="table-responsive">
            <table class="table table-sm align-middle">

                <thead class="bg-light">
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Nota</th>
                </tr>
                </thead>

                <tbody>
                @foreach($p->pagos as $pago)
                <tr>
                    <td>{{ $pago->created_at->format('d/m/Y') }}</td>
                    <td class="text-success fw-semibold">
                        ${{ number_format($pago->monto,2) }}
                    </td>
                    <td>{{ ucfirst($pago->metodo) }}</td>
                    <td class="text-muted">{{ $pago->nota ?? '—' }}</td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        @endif

    </div>
</div>

@endforeach


@endif

</div>



{{-- ========= TAB 5 : ORTODONCIA ========= --}}
<div class="tab-pane fade" id="ortodoncia">

    {{-- ===============================
        INICIAR ORTODONCIA (SI NO EXISTE)
    ================================ --}}
@if(!$paciente->ortodoncia)
<div class="card border-0 shadow-sm mb-3 ortho-start">

    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="ortho-avatar">
                <i class="fa-solid fa-play"></i>
            </div>
            <div>
                <div class="ortho-start-title">
                    Iniciar tratamiento de ortodoncia
                </div>
                <div class="ortho-hint">
                    Registro clínico inicial del caso ortodóncico
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('ortodoncia.guardar') }}">
            @csrf
            <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

            <div class="row g-3">

                {{-- Tipo de brackets --}}
                <div class="col-md-6">
                    <label class="ortho-label">Tipo de brackets</label>
                    <select name="tipo_brackets" class="form-select" required>
                        <option value="">Seleccione tipo</option>
                        <option value="metalicos">Metálicos</option>
                        <option value="esteticos">Estéticos</option>
                        <option value="autoligado">Autoligado</option>
                        <option value="alineadores">Alineadores</option>
                    </select>
                </div>

                {{-- Fecha inicio --}}
                <div class="col-md-6">
                    <label class="ortho-label">Fecha de inicio del tratamiento</label>
                    <input type="date"
                           name="fecha_inicio"
                           class="form-control"
                           required>
                </div>

                {{-- Diagnóstico --}}
                <div class="col-12">
                    <label class="ortho-label">Diagnóstico ortodóncico inicial</label>
                    <textarea name="diagnostico"
                              class="form-control"
                              rows="3"
                              placeholder="Ej. Clase II esquelética, apiñamiento severo, mordida cruzada posterior..."></textarea>
                    <div class="ortho-hint mt-1">
                        Este diagnóstico quedará como base clínica del tratamiento.
                    </div>
                </div>

            </div>

            {{-- CTA --}}
            <div class="text-end mt-4">
                <button class="btn btn-primary btn-ortho-primary">
                    <i class="fa-solid fa-check me-1"></i>
                    Iniciar tratamiento ortodóncico
                </button>
            </div>

        </form>

    </div>
</div>
@endif



    {{-- ===============================
        RESUMEN ORTODONCIA
    ================================ --}}
@if($paciente->ortodoncia)
<div class="card border-0 shadow-sm mb-3">

    <div class="card-body">

        <div class="ortho-summary">

            {{-- Ícono --}}
            <div class="ortho-avatar">
                <i class="fa-solid fa-tooth"></i>
            </div>

            {{-- Info principal --}}
            <div class="ortho-main">
                <div class="ortho-label">Tratamiento de ortodoncia</div>

                <div class="ortho-value">
                    Brackets tipo: {{ ucfirst($paciente->ortodoncia->tipo_brackets) }}
                </div>

                <div class="small text-muted">
                    Inicio del tratamiento:
                    {{ $paciente->ortodoncia->fecha_inicio->format('d/m/Y') }}
                </div>
            </div>

            {{-- Estado + PDF --}}
            <div class="d-flex flex-column align-items-end gap-2">

                <span class="badge 
                    badge-ortho 
                    bg-{{ $paciente->ortodoncia->estado === 'activo' ? 'success' : 'secondary' }}">
                    {{ ucfirst($paciente->ortodoncia->estado) }}
                </span>

                {{-- 📄 MENÚ PDF ORTODONCIA --}}
                <div class="dropdown">

                    <button class="btn btn-danger btn-sm dropdown-toggle"
                            data-bs-toggle="dropdown">
                        <i class="fa-solid fa-file-pdf me-1"></i>
                        Ortodoncia PDF
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        {{-- 👁 VER --}}
                        <li>
                            <a class="dropdown-item"
                            target="_blank"
                            href="{{ route('ortodoncia.timeline.pdf', $paciente->ortodoncia->id) }}?view=1">
                                <i class="fa-solid fa-eye me-2 text-primary"></i>
                                Ver documento
                            </a>
                        </li>

                        {{-- ⬇ DESCARGAR --}}
                        <li>
                            <a class="dropdown-item"
                            href="{{ route('ortodoncia.timeline.pdf', $paciente->ortodoncia->id) }}">
                                <i class="fa-solid fa-download me-2 text-success"></i>
                                Descargar
                            </a>
                        </li>

                    </ul>
                </div>


            </div>



        </div>

    </div>
</div>
@endif

    {{-- ===============================
        FLUJO CLÍNICO DEL TRATAMIENTO
    ================================ --}}
@if($paciente->ortodoncia)
<div class="card border-0 shadow-sm mb-3">

    <div class="card-header bg-warning bg-opacity-25 py-2">
        <i class="fa-solid fa-list-check me-1"></i>
        Flujo del tratamiento ortodóncico
    </div>

    <div class="card-body">
        <ul class="ortho-stepper">

            {{-- 1. DIAGNÓSTICO --}}
            <li class="ortho-step {{ $paciente->ortodoncia->diagnostico ? 'completed' : 'active' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div class="ortho-content">
                    <div class="ortho-title">1. Diagnóstico</div>
                    <div class="ortho-meta">
                        {{ $paciente->ortodoncia->diagnostico ?? 'Pendiente de registro clínico' }}
                    </div>
                </div>
            </li>

            {{-- 2. PROFILAXIS --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_profilaxis ? 'completed' : '' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-broom"></i>
                </div>
                <div class="ortho-content d-flex justify-content-between align-items-center">
                    <div>
                        <div class="ortho-title">2. Profilaxis</div>
                        <div class="ortho-meta">
                            {{ $paciente->ortodoncia->fecha_profilaxis
                                ? $paciente->ortodoncia->fecha_profilaxis->format('d/m/Y')
                                : 'Pendiente' }}
                        </div>
                    </div>

                    @if(!$paciente->ortodoncia->fecha_profilaxis)
                    <form method="POST" action="{{ route('ortodoncia.marcarPaso') }}">
                        @csrf
                        <input type="hidden" name="campo" value="fecha_profilaxis">
                        <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">
                        <button class="btn btn-outline-success btn-sm btn-ortho">
                            Registrar profilaxis realizada
                        </button>
                    </form>
                    @endif
                </div>
            </li>

            {{-- 3. COLOCACIÓN --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_colocacion ? 'completed' : '' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-tooth"></i>
                </div>
                <div class="ortho-content d-flex justify-content-between align-items-center">
                    <div>
                        <div class="ortho-title">3. Colocación de brackets</div>
                        <div class="ortho-meta">
                            {{ $paciente->ortodoncia->fecha_colocacion
                                ? $paciente->ortodoncia->fecha_colocacion->format('d/m/Y')
                                : 'Pendiente' }}
                        </div>
                    </div>

                    @if(!$paciente->ortodoncia->fecha_colocacion)
                    <form method="POST" action="{{ route('ortodoncia.marcarPaso') }}">
                        @csrf
                        <input type="hidden" name="campo" value="fecha_colocacion">
                        <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">
                        <button class="btn btn-outline-success btn-sm btn-ortho">
                            Confirmar colocación de brackets
                        </button>
                    </form>
                    @endif
                </div>
            </li>

            {{-- 4. SEGUIMIENTO --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_colocacion && !$paciente->ortodoncia->fecha_retiro ? 'active' : 'blocked' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-arrows-left-right"></i>
                </div>
                <div class="ortho-content">
                    <div class="ortho-title">4. Seguimiento (arcos)</div>
                    <div class="ortho-meta">
                        {{ $paciente->ortodoncia->citas->count() }} citas registradas
                    </div>
                </div>
            </li>

            {{-- 5. RETIRO --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_retiro ? 'completed' : '' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="ortho-content d-flex justify-content-between align-items-center">
                    <div>
                        <div class="ortho-title">5. Retiro de brackets</div>
                        <div class="ortho-meta">
                            {{ $paciente->ortodoncia->fecha_retiro
                                ? $paciente->ortodoncia->fecha_retiro->format('d/m/Y')
                                : 'Pendiente' }}
                        </div>
                    </div>

                    @if(!$paciente->ortodoncia->fecha_retiro)
                    <form method="POST" action="{{ route('ortodoncia.marcarPaso') }}">
                        @csrf
                        <input type="hidden" name="campo" value="fecha_retiro">
                        <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">
                        <button class="btn btn-outline-danger btn-sm btn-ortho">
                            Registrar retiro de brackets
                        </button>
                    </form>
                    @endif
                </div>
            </li>

            {{-- 6. RETENEDORES --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_retenedores ? 'completed' : '' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-shield-heart"></i>
                </div>
                <div class="ortho-content d-flex justify-content-between align-items-center">
                    <div>
                        <div class="ortho-title">6. Colocación de retenedores</div>
                        <div class="ortho-meta">
                            {{ $paciente->ortodoncia->fecha_retenedores
                                ? $paciente->ortodoncia->fecha_retenedores->format('d/m/Y')
                                : 'Pendiente' }}
                        </div>
                    </div>

                    @if(!$paciente->ortodoncia->fecha_retenedores)
                    <form method="POST" action="{{ route('ortodoncia.marcarPaso') }}">
                        @csrf
                        <input type="hidden" name="campo" value="fecha_retenedores">
                        <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">
                        <button class="btn btn-outline-success btn-sm btn-ortho">
                            Registrar colocación de retenedores
                        </button>
                    </form>
                    @endif
                </div>
            </li>

            {{-- 7. FIN --}}
            <li class="ortho-step {{ $paciente->ortodoncia->fecha_fin ? 'completed' : '' }}">
                <div class="ortho-icon">
                    <i class="fa-solid fa-flag-checkered"></i>
                </div>
                <div class="ortho-content d-flex justify-content-between align-items-center">
                    <div>
                        <div class="ortho-title">7. Fin del tratamiento</div>
                        <div class="ortho-meta">
                            {{ $paciente->ortodoncia->fecha_fin
                                ? $paciente->ortodoncia->fecha_fin->format('d/m/Y')
                                : 'Pendiente' }}
                        </div>
                    </div>

                    @if(!$paciente->ortodoncia->fecha_fin)
                    <form method="POST" action="{{ route('ortodoncia.marcarPaso') }}">
                        @csrf
                        <input type="hidden" name="campo" value="fecha_fin">
                        <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">
                        <button class="btn btn-outline-dark btn-sm btn-ortho">
                            Finalizar tratamiento ortodóncico
                        </button>
                    </form>
                    @endif
                </div>
            </li>

        </ul>
    </div>
</div>
@endif


    {{-- ===============================
        REGISTRAR CITA
    ================================ --}}
@if(
    $paciente->ortodoncia &&
    $paciente->ortodoncia->fecha_colocacion &&
    !$paciente->ortodoncia->fecha_retiro &&
    $paciente->ortodoncia->estado !== 'finalizado'
)
    <div class="card border-0 shadow-sm mb-3">

        <div class="card-header bg-success bg-opacity-25 py-2">
            <i class="fa-solid fa-calendar-plus me-1"></i>
            Registrar cita de ortodoncia
        </div>

        <div class="card-body">

<form method="POST" action="{{ route('ortodoncia.cita.guardar') }}">
    @csrf
    <input type="hidden" name="ortodoncia_id" value="{{ $paciente->ortodoncia->id }}">

    <div class="row g-3">

        {{-- Arco superior --}}
        <div class="col-md-6">
            <label for="arco_sup" class="form-label fw-semibold">Arco superior</label>
            <textarea id="arco_sup"
                      name="arco_superior"
                      class="form-control shadow-sm"
                      rows="2"
                      placeholder="Escribe los detalles del arco superior, ej. 18, movimientos, observaciones"></textarea>
        </div>

        {{-- Arco inferior --}}
        <div class="col-md-6">
            <label for="arco_inf" class="form-label fw-semibold">Arco inferior</label>
            <textarea id="arco_inf"
                      name="arco_inferior"
                      class="form-control shadow-sm"
                      rows="2"
                      placeholder="Escribe los detalles del arco inferior, ej. 18, movimientos, observaciones"></textarea>
        </div>

    </div>

    <div class="text-end mt-3">
        <button class="btn btn-success btn-sm">
            <i class="fa-solid fa-check me-1"></i>
            Guardar cita
        </button>
    </div>

</form>


        </div>
    </div>
    @endif


    {{-- ===============================
        HISTORIAL DE CITAS
    ================================ --}}
@if(
    $paciente->ortodoncia &&
    $paciente->ortodoncia->fecha_colocacion &&
    !$paciente->ortodoncia->fecha_retiro &&
    $paciente->ortodoncia->citas->count()
)


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-secondary bg-opacity-25 py-2">
            <i class="fa-solid fa-clock-rotate-left me-1"></i>
            Historial de citas
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light small">
                        <tr>
                            <th class="ps-3">Fecha</th>
                            <th>Arco Superior</th>
                            <th>Arco Inferior</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paciente->ortodoncia->citas->sortByDesc('created_at') as $cita)
                        <tr>
                            <td class="ps-3">{{ $cita->created_at->format('d/m/Y') }}</td>
                            <td>{{ $cita->arco_superior ?? '—' }}</td>
                            <td>{{ $cita->arco_inferior ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @endif

</div>


@endsection
