@php
    use App\Models\CatalogoLimpieza;

    $limpiezaActiva = $paciente->limpiezaActiva;

    $historialLimpiezas = $paciente->limpiezas()
        ->orderByDesc('fecha_inicio')
        ->get();

    $catalogoLimpiezas = CatalogoLimpieza::where('activo', 1)
        ->orderBy('nombre')
        ->get();

    $totalAplicado = 0;
    $pendiente = 0;
    $porcentaje = 0;

    if ($limpiezaActiva) {
        $totalAplicado = $limpiezaActiva->seguimientos->sum('pago');

        $pendiente = max(
            0,
            $limpiezaActiva->costo_total - $totalAplicado
        );

        if ($limpiezaActiva->costo_total > 0) {
            $porcentaje = round(
                ($totalAplicado * 100) /
                $limpiezaActiva->costo_total
            );
        }
    }
@endphp

<div class="card border-0 shadow-sm mb-3">
    @if($limpiezaActiva || $historialLimpiezas->count() > 0)
        <div class="card-body">
            <div class="ortho-summary">
                {{-- ICONO --}}
                <div class="ortho-avatar bg-success bg-opacity-25 text-white">
                    <i class="fa-solid fa-tooth"></i>
                </div>

                {{-- INFORMACIÓN --}}
                <div class="ortho-main">
                    <div class="ortho-label">
                        Tratamiento de limpieza dental
                    </div>

                    <div class="ortho-value">
                        @if($limpiezaActiva)
                            Limpieza activa
                        @else
                            Sin limpieza activa
                        @endif
                    </div>

                    <small class="opacity-75">
                        Registro y seguimiento clínico de limpiezas
                    </small>
                </div>

                {{-- ESTADO --}}
                <div class="d-flex flex-column align-items-end gap-2">
                    @if($limpiezaActiva)
                        <span class="badge bg-success">
                            Activa
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            Inactiva
                        </span>
                    @endif

                    @if(!$limpiezaActiva)
                        <button
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalNuevaLimpieza">
                            <i class="fa-solid fa-plus me-1"></i>
                            Nueva limpieza
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ================= BODY ================= --}}
    <div class="card-body">

        {{-- ================= LIMPIEZA ACTIVA ================= --}}
        @if($limpiezaActiva)

            <div class="card border-2 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold text-black mb-2">
                                <i class="fa-solid fa-circle-play me-1 text-success"></i>
                                Limpieza dental en curso
                            </div>

                            <div class="small text-muted">
                                <div>
                                    <strong>Inicio:</strong>
                                    {{ $limpiezaActiva->fecha_inicio->format('d/m/Y') }}
                                </div>

                                <div>
                                    <strong>Costo total:</strong>
                                    ${{ number_format($limpiezaActiva->costo_total, 2) }}
                                </div>

                                <div>
                                    <strong>Aplicado:</strong>
                                    ${{ number_format($totalAplicado, 2) }}
                                </div>

                                <div>
                                    <strong>Pendiente:</strong>
                                    ${{ number_format($pendiente, 2) }}
                                </div>

                                <div class="mt-2">
                                    <strong>Avance:</strong>
                                    {{ $porcentaje }} %
                                </div>

                                <div class="progress mt-2" style="height:8px">
                                    <div
                                        class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: {{ $porcentaje }}%">
                                    </div>
                                </div>
                            </div>

                            @if($limpiezaActiva->observaciones)
                                <div class="fst-italic text-muted small mt-3">
                                    <strong>Observaciones:</strong>
                                    {{ $limpiezaActiva->observaciones }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-column gap-2 text-end">
                            <button
                                class="btn btn-outline-secondary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalSeguimientoLimpieza">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>
                                Seguimiento
                            </button>

                            {{-- PDF LIMPIEZA --}}
                            <div class="dropdown">
                                <button
                                    class="btn btn-danger btn-sm dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-file-pdf me-1"></i>
                                    Limpieza PDF
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            target="_blank"
                                            href="{{ route('limpiezas.timeline.pdf', $limpiezaActiva) }}?view=1">
                                            <i class="fa-solid fa-eye me-2 text-primary"></i>
                                            Ver documento
                                        </a>
                                    </li>

                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="{{ route('limpiezas.timeline.pdf', $limpiezaActiva) }}">
                                            <i class="fa-solid fa-download me-2 text-success"></i>
                                            Descargar
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button
                                class="btn btn-outline-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalFinalizarLimpieza">
                                <i class="fa-solid fa-check me-1"></i>
                                Finalizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        
{{-- ================= HISTORIAL ================= --}}

@foreach($historialLimpiezas as $limpieza)
    @if(!$limpiezaActiva || $limpieza->id !== $limpiezaActiva->id)
        <div class="card mb-3 border {{ $limpieza->estado === 'finalizada' ? 'border-success' : 'border-secondary' }}">
            <div class="card-body d-flex justify-content-between align-items-start">

                {{-- INFORMACIÓN --}}
                <div>
                    <h6 class="mb-1">
                        Limpieza dental

                        <span class="badge bg-{{ $limpieza->estado === 'finalizada' ? 'success' : 'secondary' }} ms-2">
                            {{ ucfirst($limpieza->estado) }}
                        </span>
                    </h6>

                    <div class="small text-muted">
                        <div>
                            <strong>Inicio:</strong>
                            {{ $limpieza->fecha_inicio->format('d/m/Y') }}
                        </div>

                        <div>
                            <strong>Fin:</strong>
                            {{ $limpieza->fecha_termino?->format('d/m/Y') ?? '—' }}
                        </div>

                        <div>
                            <strong>Costo total:</strong>
                            ${{ number_format($limpieza->costo_total, 2) }}
                        </div>
                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="d-flex flex-column gap-2 text-end">

                    {{-- PDF LIMPIEZA HISTORIAL --}}
                    <div class="dropdown">
                        <button
                            class="btn btn-danger btn-sm dropdown-toggle"
                            data-bs-toggle="dropdown">
                            <i class="fa-solid fa-file-pdf me-1"></i>
                            Limpieza PDF
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a
                                    class="dropdown-item"
                                    target="_blank"
                                    href="{{ route('limpiezas.timeline.pdf', $limpieza) }}?view=1">
                                    <i class="fa-solid fa-eye me-2 text-primary"></i>
                                    Ver documento
                                </a>
                            </li>

                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('limpiezas.timeline.pdf', $limpieza) }}">
                                    <i class="fa-solid fa-download me-2 text-success"></i>
                                    Descargar
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    @endif
@endforeach

@if(!$limpiezaActiva && $historialLimpiezas->count() === 0)
    <div class="text-center p-4">
        <i class="fa-solid fa-tooth fa-2x text-muted mb-2"></i>

        <div class="fw-semibold mb-1">
            Sin registros de limpieza
        </div>

        <div class="small text-muted mb-3">
            Inicie un nuevo tratamiento de limpieza para este paciente
        </div>

        <button
            class="btn btn-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#modalNuevaLimpieza">
            <i class="fa-solid fa-plus me-1"></i>
            Nueva limpieza
        </button>
    </div>
@endif

    </div>
</div>

{{-- ================================================= --}}
{{-- MODAL NUEVA LIMPIEZA --}}
{{-- ================================================= --}}

@if(!$limpiezaActiva)
    <div
        class="modal fade"
        id="modalNuevaLimpieza"
        tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form
                method="POST"
                action="{{ route('limpiezas.store', $paciente->id) }}"
                class="modal-content border-0 shadow-sm rounded-3 overflow-hidden">

                @csrf

                <div class="modal-header bg-success bg-opacity-10 border-bottom">
                    <h5 class="modal-title fw-semibold">
                        <i class="fa-solid fa-tooth me-2"></i>
                        Nuevo tratamiento de limpieza
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Fecha inicio *
                            </label>

                            <input
                                type="date"
                                name="fecha_inicio"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Costo total *
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="costo_total"
                                class="form-control"
                                placeholder="Ejemplo: 1500"
                                required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Observaciones
                            </label>

                            <textarea
                                name="observaciones"
                                class="form-control"
                                rows="3"
                                placeholder="Notas clínicas..."></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button class="btn btn-success">
                        <i class="fa-solid fa-check me-1"></i>
                        Registrar
                    </button>
                </div>

            </form>
        </div>
    </div>
@endif

{{-- ================================================= --}}
{{-- MODAL SEGUIMIENTO --}}
{{-- ================================================= --}}

@if($limpiezaActiva)
    <div
        class="modal fade"
        id="modalSeguimientoLimpieza"
        tabindex="-1">

        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <div class="modal-header bg-success bg-opacity-10">
                    <h5 class="modal-title fw-semibold">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>
                        Seguimiento de limpieza dental
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">

                        {{-- FORMULARIO --}}
                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">

                                    <h6 class="fw-semibold mb-3">
                                        <i class="fa-solid fa-plus me-1"></i>
                                        Nuevo servicio realizado
                                    </h6>

                                    <form
                                        id="formSeguimientoLimpieza"
                                        method="POST"
                                        action="{{ route('limpiezas.seguimiento.store', $limpiezaActiva->id) }}">

                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Servicio *
                                            </label>
                                            <select
                                                id="catalogo_limpieza_id"
                                                name="catalogo_limpieza_id"
                                                class="form-select"
                                                required>

                                                <option disabled selected>
                                                    Seleccionar
                                                </option>

                                                @foreach($catalogoLimpiezas as $servicio)
                                                    <option value="{{ $servicio->id }}">
                                                        {{ $servicio->nombre }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Fecha *
                                            </label>

                                            <input
                                                id="fecha"
                                                type="date"
                                                name="fecha"
                                                class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Pago realizado *
                                            </label>

                                            <input
                                                id="pago"
                                                type="number"
                                                step="0.01"
                                                name="pago"
                                                class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Próxima cita
                                            </label>

                                            <input
                                                id="proxima_cita"
                                                type="date"
                                                name="proxima_cita"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Observaciones
                                            </label>

                                            <textarea
                                                id="observaciones"
                                                name="observaciones"
                                                class="form-control"
                                                rows="3"></textarea>
                                        </div>
                                        <input
                                            type="hidden"
                                            name="firma"
                                            id="firmaSeguimiento">
                                      <button
                                            type="button"
                                            class="btn btn-success"
                                            id="btnContinuarFirma">

                                            <i class="fa-solid fa-check me-1"></i>
                                            Continuar

                                        </button>

                                    </form>

                                </div>
                            </div>
                        </div>

                        {{-- TABLA HISTORIAL --}}
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">

                                    <h6 class="fw-semibold mb-3">
                                        Servicios realizados
                                    </h6>

                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle">

                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Servicio</th>
                                                    <th style="width:35%">Observaciones</th>
                                                    <th>Pago</th>
                                                    <th>Próxima cita</th>
                                                    <th>Firma</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($limpiezaActiva->seguimientos as $seguimiento)
                                                <tr>
                                                    <td class="small">
                                                        {{ $seguimiento->fecha->format('d/m/Y') }}
                                                    </td>

                                                    <td class="small">
                                                        {{ $seguimiento->catalogo->nombre ?? '—' }}
                                                    </td>

                                                    <td class="small" style="max-width:250px; white-space:normal;">
                                                        @if($seguimiento->observaciones)
                                                            {{ $seguimiento->observaciones }}
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>

                                                    <td class="small">
                                                        ${{ number_format($seguimiento->pago, 2) }}
                                                    </td>

                                                    <td class="small">
                                                        {{ $seguimiento->proxima_cita?->format('d/m/Y') ?? '—' }}
                                                    </td>
                                                    <td class="small text-center">
                                                        @if($seguimiento->firma)
                                                            <button
                                                                type="button"
                                                                class="btn btn-outline-success btn-sm btnVerFirma"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalVerFirma"
                                                                data-firma="{{ $seguimiento->id }}">
                                                                <i class="fa-solid fa-signature"></i>
                                                            </button>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        Sin seguimientos registrados
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif

{{-- ================================================= --}}
{{-- MODAL FINALIZAR --}}
{{-- ================================================= --}}

@if($limpiezaActiva)
    <div
        class="modal fade"
        id="modalFinalizarLimpieza"
        tabindex="-1">

        <div class="modal-dialog modal-md modal-dialog-centered">

            <form
                method="POST"
                action="{{ route('limpiezas.finalizar', $limpiezaActiva->id) }}"
                class="modal-content">

                @csrf

                <div class="modal-header bg-success bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-check me-2"></i>
                        Finalizar limpieza
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Fecha finalización *
                        </label>

                        <input
                            type="date"
                            name="fecha_termino"
                            class="form-control"
                            required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button class="btn btn-success">
                        Finalizar
                    </button>
                </div>

            </form>

        </div>
    </div>
@endif


{{-- ================================================= --}}
{{-- MODAL CONFIRMACION SERVICIO --}}
{{-- ================================================= --}}

<div
    class="modal fade"
    id="modalConfirmarServicio"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success bg-opacity-10">
                <h5 class="modal-title fw-semibold">
                    Confirmación del servicio
                </h5>
            </div>


            <div class="modal-body">
                <div id="resumenServicio">
                    <div class="mb-3">
                        <h5 class="fw-bold text-success mb-4">
                            CONFIRMACIÓN DEL SERVICIO
                        </h5>
                        <p class="mb-2">
                            <strong>Servicio:</strong>
                            <span id="txtServicio"></span>
                        </p>
                        <p class="mb-2">
                            <strong>Fecha:</strong>
                            <span id="txtFecha"></span>
                        </p>
                        <p class="mb-2">
                            <strong>Pago:</strong>
                            $<span id="txtPago"></span>
                        </p>
                        <p class="mb-2">
                            <strong>Próxima cita:</strong>
                            <span id="txtProxima"></span>
                        </p>
                        <p class="mb-3">
                            <strong>Observaciones:</strong><br>
                            <span id="txtObservaciones"></span>
                        </p>
                        <hr>
                        <p class="small text-muted">
                            Declaro que la información anterior corresponde al tratamiento
                            realizado en esta sesión y estoy de acuerdo con el servicio recibido.
                        </p>
                        <div class="mt-4">
                        <label class="fw-semibold mb-2">
                            Firma del paciente
                        </label>
                        <div class="border rounded p-2 text-center">
                            <canvas
                                id="canvasFirmaSeguimiento"
                                style="border:1px solid #ccc; border-radius:6px; width:100%; height:250px;">
                            </canvas>
                        </div>
                        <button
                            type="button"
                            class="btn btn-warning btn-sm mt-2"
                            id="limpiarFirmaSeguimiento">
                            <i class="fa-solid fa-trash me-1"></i>
                            Limpiar firma
                        </button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button
                    type="button"
                    class="btn btn-success"
                    id="btnGuardarSeguimiento">
                    Confirmar y guardar
                </button>
            </div>
        </div>
    </div>
</div>


<div
    class="modal fade"
    id="modalVerFirma"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success bg-opacity-10">
                <h5 class="modal-title fw-semibold">
                    Firma del paciente
                </h5>
                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body text-center">
                <img
                    id="imagenFirma"
                    src=""
                    class="img-fluid border rounded p-2"
                    style="max-height:250px;">
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
let signaturePadSeguimiento;

document.addEventListener('DOMContentLoaded', function () {
    function formatearFecha(fecha) {
        if (!fecha) return '—';
        const partes = fecha.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }

    /*
    |--------------------------------------------------------------------------
    | Abrir modal de firma
    |--------------------------------------------------------------------------
    */

    const btnContinuar = document.getElementById('btnContinuarFirma');
    if (btnContinuar) {
        btnContinuar.addEventListener('click', function () {
            const form = document.getElementById('formSeguimientoLimpieza');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            const servicio = document.getElementById('catalogo_limpieza_id');
            const fecha = document.getElementById('fecha').value;
            const pago = document.getElementById('pago').value;
            const proxima = document.getElementById('proxima_cita').value;
            const observaciones = document.getElementById('observaciones').value;
            document.getElementById('txtServicio').textContent =
                servicio.options[servicio.selectedIndex].text;
            document.getElementById('txtFecha').textContent =
                formatearFecha(fecha);
            document.getElementById('txtPago').textContent =
                pago ? Number(pago).toFixed(2) : '0.00';
            document.getElementById('txtProxima').textContent =
                formatearFecha(proxima);
            document.getElementById('txtObservaciones').textContent =
                observaciones.trim() !== ''
                    ? observaciones
                    : 'Sin observaciones.';
            const modalSeguimiento = bootstrap.Modal.getInstance(
                document.getElementById('modalSeguimientoLimpieza')
            );
            if (modalSeguimiento) {
                modalSeguimiento.hide();
            }
            setTimeout(function () {
                const modalConfirmacion =
                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('modalConfirmarServicio')
                    );
                modalConfirmacion.show();
            }, 300);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Inicializar SignaturePad
    |--------------------------------------------------------------------------
    */

    const modalConfirmarServicio =
        document.getElementById('modalConfirmarServicio');
    if (modalConfirmarServicio) {
        modalConfirmarServicio.addEventListener('shown.bs.modal', function () {
            const canvas =
                document.getElementById('canvasFirmaSeguimiento');
            canvas.width = canvas.offsetWidth;
            canvas.height = 250;
            signaturePadSeguimiento = new SignaturePad(canvas);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Limpiar firma
    |--------------------------------------------------------------------------
    */

    const btnLimpiar =
        document.getElementById('limpiarFirmaSeguimiento');
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function () {
            if (signaturePadSeguimiento) {
                signaturePadSeguimiento.clear();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Confirmar y guardar
    |--------------------------------------------------------------------------
    */

    const btnGuardar =
        document.getElementById('btnGuardarSeguimiento');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function () {
            if (!signaturePadSeguimiento || signaturePadSeguimiento.isEmpty()) {
                alert('⚠ La firma del paciente es obligatoria');
                return;
            }
            document.getElementById('firmaSeguimiento').value =
                signaturePadSeguimiento.toDataURL('image/png');
            document.getElementById('formSeguimientoLimpieza').submit();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Mostrar firma
    |--------------------------------------------------------------------------
    */
    const firmasSeguimientos = {
    @if($limpiezaActiva)
        @foreach($limpiezaActiva->seguimientos as $seguimiento)
            "{{ $seguimiento->id }}": @js($seguimiento->firma),
        @endforeach
    @endif
    };
    document.querySelectorAll('.btnVerFirma').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.firma;
            const firma = firmasSeguimientos[id];
            document.getElementById('imagenFirma').src = firma;

        });
    });
    });

</script>