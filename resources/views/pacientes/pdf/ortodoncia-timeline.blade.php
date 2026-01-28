<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    margin: 15px 20px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #222;
    line-height: 1.15;
}

.formato {
    border: 2px solid #0d6efd;
    padding: 10px;
    border-radius: 8px;
}

/* ===== TITULOS ===== */
h2 { font-size: 13px; margin-bottom: 3px; }
h3 { font-size: 12px; margin-bottom: 4px; }

/* ===== SECCIONES ===== */
.section {
    margin-bottom: 6px;
}

/* ===== TABLAS ===== */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9px;
}

th, td {
    border: 1px solid #999;
    padding: 3px;
    text-align: center;
}

th {
    background: #f0f0f0;
}

p {
    margin: 2px 0;
}

/* ===== FIRMA ===== */
.firma-img {
    max-width: 180px;
    max-height: 75px;
    border: 1px solid #ccc;
    padding: 3px;
}


/* ===== TIMELINE ===== */
.timeline-premium {
    margin-top: 6px;
}

/* CARD */
.timeline-card {
    position: relative;
    margin-left: 22px;
    margin-bottom: 10px;
    padding: 6px 8px;
    border-radius: 6px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    font-size: 9.5px;
}

/* PUNTO */
.timeline-dot {
    position: absolute;
    left: -12px;
    top: 8px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #6c757d;
}

/* ESTADOS */
.timeline-card.completed {
    border-left: 4px solid #198754;
}
.timeline-card.completed .timeline-dot {
    background: #198754;
}

.timeline-card.progress {
    border-left: 4px solid #fd7e14;
}
.timeline-card.progress .timeline-dot {
    background: #fd7e14;
}

/* TEXTOS */
.timeline-title {
    font-size: 10px;
    font-weight: bold;
}
.timeline-date {
    font-size: 9px;
    color: #555;
}
.timeline-desc {
    font-size: 9px;
}
.timeline-status {
    font-size: 9px;
    font-weight: bold;
    margin-top: 2px;
}

/* TABLA ARCOS */
.timeline-card table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5px;
    margin-top: 4px;
}
.timeline-card th,
.timeline-card td {
    border: 1px solid #ccc;
    padding: 3px;
    text-align: center;
}
.timeline-card thead {
    background: #f1f3f5;
}
</style>

</head>

<body>

<div class="formato">

<!-- ===== ENCABEZADO ===== -->
<table style="border:none; width:100%;">
<tr>
<td style="border:none; width:20%; text-align:center;">
    <img src="{{ public_path('images/logo.png') }}"
     style="
        max-width:100px;
        max-height:100px;
        object-fit:contain;
        display:block;
        margin:auto;
     ">
</td>

<td style="border:none; width:60%; text-align:center;">
    <h2 style="color:#0d6efd;">ORTHO CARE</h2>
    <p>
        Licenciado en Odontología – Cédula: <strong>8299663</strong><br>
        Especialidad en Ortodoncia y Ortopedia Maxilar – Cédula: <strong>12383864</strong><br>
        Tel: <strong>5510090611</strong>
    </p>
</td>

<td style="border:none; width:20%; text-align:right;">
    <strong>Fecha:</strong><br>
    {{ now()->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
</td>
</tr>
</table>

<hr>

<!-- ===== TITULO ===== -->
<div class="section" style="text-align:center;">
    <h3 style="color:#0d6efd;">TIMELINE CLÍNICO DE ORTODONCIA</h3>
</div>

<hr>

<!-- ===== DATOS PACIENTE ===== -->
<div class="section">
    <strong>Paciente:</strong> {{ $ortodoncia->paciente->nombre }}<br>
    <strong>Tipo de brackets:</strong> {{ ucfirst($ortodoncia->tipo_brackets) }}<br>
    <strong>Fecha de inicio:</strong> {{ $ortodoncia->fecha_inicio->format('d/m/Y') }}<br>
    <strong>Estado actual:</strong> {{ ucfirst($ortodoncia->estado) }}
</div>

<hr>

<!-- ===== TIMELINE ===== -->
<div class="timeline-premium">

{{-- 1. Diagnóstico --}}
<div class="timeline-card completed">
    <div class="timeline-title">1. Diagnóstico inicial</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_inicio->format('d/m/Y') }}</div>
    <div class="timeline-desc">{{ $ortodoncia->diagnostico }}</div>
    <div class="timeline-status" style="color:#198754;">Completado</div>
</div>

{{-- 2. Profilaxis --}}
@if($ortodoncia->fecha_profilaxis)
<div class="timeline-card completed">
    <div class="timeline-title">2. Profilaxis previa</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_profilaxis->format('d/m/Y') }}</div>
    <div class="timeline-desc">Limpieza y preparación previa.</div>
    <div class="timeline-status" style="color:#198754;">Completado</div>
</div>
@endif

{{-- 3. Colocación --}}
@if($ortodoncia->fecha_colocacion)
<div class="timeline-card completed">
    <div class="timeline-title">3. Colocación de brackets</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_colocacion->format('d/m/Y') }}</div>
    <div class="timeline-desc">Instalación de aparatología.</div>
    <div class="timeline-status" style="color:#198754;">Completado</div>
</div>
@endif

{{-- 4. Seguimiento --}}
@if($ortodoncia->fecha_colocacion)
<div class="timeline-card {{ $ortodoncia->fecha_retiro ? 'completed' : 'progress' }}">
    <div class="timeline-title">4. Seguimiento clínico (arcos)</div>
    <div class="timeline-desc">{{ $ortodoncia->citas->count() }} citas registradas</div>

    @if($ortodoncia->citas->count())
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Arco Sup.</th>
                <th>Arco Inf.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ortodoncia->citas as $cita)
            <tr>
                <td>{{ $cita->created_at->format('d/m/Y') }}</td>
                <td>{{ $cita->arco_superior ?? '—' }}</td>
                <td>{{ $cita->arco_inferior ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="timeline-status" style="color:{{ $ortodoncia->fecha_retiro ? '#198754' : '#fd7e14' }}">
        {{ $ortodoncia->fecha_retiro ? 'Completado' : 'En progreso' }}
    </div>
</div>
@endif

{{-- 5. Retiro --}}
@if($ortodoncia->fecha_retiro)
<div class="timeline-card completed">
    <div class="timeline-title">5. Retiro de brackets</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_retiro->format('d/m/Y') }}</div>
    <div class="timeline-desc">Retiro completo de aparatología.</div>
    <div class="timeline-status" style="color:#198754;">Completado</div>
</div>
@endif

{{-- 6. Retenedores --}}
@if($ortodoncia->fecha_retenedores)
<div class="timeline-card completed">
    <div class="timeline-title">6. Colocación de retenedores</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_retenedores->format('d/m/Y') }}</div>
    <div class="timeline-desc">Ajuste y entrega de retenedores.</div>
    <div class="timeline-status" style="color:#198754;">Completado</div>
</div>
@endif

{{-- 7. Fin --}}
@if($ortodoncia->fecha_fin)
<div class="timeline-card completed">
    <div class="timeline-title">7. Fin del tratamiento</div>
    <div class="timeline-date">{{ $ortodoncia->fecha_fin->format('d/m/Y') }}</div>
    <div class="timeline-desc">Alta clínica del tratamiento.</div>
    <div class="timeline-status" style="color:#198754;">Finalizado</div>
</div>
@endif

</div>

<hr>

<!-- ===== LEYENDA ===== -->
<p style="font-size:8px; text-align:justify; color:#555;">
<strong>Aviso de Privacidad:</strong>  
Los datos personales, clínicos y financieros contenidos en este documento son tratados de forma confidencial por <strong>ORTHO CARE</strong> para fines de diagnóstico, tratamiento, seguimiento y control administrativo, de acuerdo con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares. La información aquí contenida tiene carácter confidencial y, en su caso, validez clínica y legal conforme a la normatividad sanitaria vigente.
</p>

<p style="font-size:8px; text-align:center; color:#0d6efd;">
Documento generado electrónicamente · ORTHO CARE · Expediente Clínico
</p>


</div>
</body>
</html>
