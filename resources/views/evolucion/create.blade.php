@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="header-title mb-0">
                <i class="bi bi-file-medical me-2 text-primary"></i>
                Nota Evolutiva
            </h3>
            <div class="subtitle">Registrar evolución clínica del paciente</div>
        </div>

        <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- ===== DATOS DEL PACIENTE ===== --}}
    <div class="card shadow-soft mb-4">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            <i class="bi bi-person-circle me-1"></i> Datos del Paciente
        </div>
        <div class="card-body">
            <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }}</p>
            <p><strong>Fecha de cita:</strong> {{ date('d/m/Y H:i', strtotime($cita->fecha_hora)) }}</p>
        </div>
    </div>

    {{-- ===== FORMULARIO EVOLUCIÓN ===== --}}
    <form id="formEvolucion" action="{{ route('evolucion.store', $cita) }}" method="POST">
        @csrf

        <div class="card shadow-soft mb-4">
            <div class="card-header bg-info bg-opacity-25 fw-semibold">
                <i class="bi bi-clipboard-check me-1"></i> Registro de Evolución
            </div>

            <div class="card-body">
            {{-- Diagnóstico --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Diagnóstico *</label>
                <textarea name="diagnostico"
                        class="form-control shadow-sm"
                        rows="3"
                        placeholder="Ej: Caries profunda en molar 36, con compromiso pulpar y dolor a la percusión."
                        required></textarea>
            </div>

            {{-- Procedimiento --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Procedimiento *</label>
                <textarea name="procedimiento"
                        class="form-control shadow-sm"
                        rows="3"
                        placeholder="Ej: Apertura cameral, remoción de tejido cariado, tratamiento de conductos y obturación provisional."
                        required></textarea>
            </div>

            {{-- Indicaciones --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Indicaciones</label>
                <textarea name="indicaciones"
                        class="form-control shadow-sm"
                        rows="2"
                        placeholder="Ej: No ingerir alimentos hasta pasar la anestesia. Tomar analgésico prescrito cada 8 horas. Mantener higiene oral."></textarea>
            </div>

            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2">
            <button type="button" id="btnAbrirFirma" class="btn btn-success shadow-sm">
                <i class="bi bi-save me-1"></i> Guardar Nota Evolutiva
            </button>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-x-lg me-1"></i> Cancelar
            </a>
        </div>
    </form>

</div>

{{-- ===== MODAL FIRMA ===== --}}
<div class="modal fade" id="modalFirma" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Firma del Paciente</h5>
            </div>

            <div class="modal-body text-center">

                <p class="fw-bold mb-3">
                    Acepto tratamiento y evolución descrita
                </p>

                <canvas id="canvasFirma" style="border:1px solid #ccc; border-radius:6px; width:100%; height:250px;"></canvas>

                <button type="button" class="btn btn-warning mt-3 shadow-sm" id="limpiarFirma">
                    <i class="bi bi-trash me-1"></i> Limpiar
                </button>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary shadow-sm" id="guardarConFirma">
                    <i class="bi bi-check-circle me-1"></i> Guardar con Firma
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* Caja para la firma */
#canvasFirma {
    background: #fafafa;
}
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
let signaturePad;
let modalFirma = new bootstrap.Modal(document.getElementById('modalFirma'));

// Abrir modal
document.getElementById('btnAbrirFirma').addEventListener('click', () => {
    modalFirma.show();
});

// Inicializar canvas al abrir modal
document.getElementById('modalFirma').addEventListener('shown.bs.modal', () => {
    const canvas = document.getElementById('canvasFirma');
    canvas.width = canvas.offsetWidth;
    canvas.height = 250;
    signaturePad = new SignaturePad(canvas);
});

// Limpiar firma
document.getElementById('limpiarFirma').addEventListener('click', () => {
    signaturePad.clear();
});

// Guardar con firma
document.getElementById('guardarConFirma').addEventListener('click', () => {
    if (signaturePad.isEmpty()) {
        alert('⚠ La firma es obligatoria');
        return;
    }

    const form = document.getElementById('formEvolucion');

    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'firma_base64';
    input.value = signaturePad.toDataURL('image/png');

    form.appendChild(input);
    form.submit();
});
</script>
@endpush
