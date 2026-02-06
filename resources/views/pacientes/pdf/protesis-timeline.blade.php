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
h3 { font-size: 12px; margin-bottom: 4px; color:#0d6efd; }

/* ===== SECCIONES ===== */
.section {
    margin-bottom: 8px;
}

/* ===== TEXTO ===== */
.text-muted {
    color: #555;
    font-size: 9px;
}

/* ===== BADGES ===== */
.badge {
    display: inline-block;
    padding: 2px 6px;
    font-size: 8.5px;
    border-radius: 10px;
    background: #cfe2ff;
    color: #0d6efd;
    font-weight: bold;
}

/* ===== TIMELINE ===== */
.timeline {
    border-left: 2px solid #0d6efd;
    padding-left: 12px;
    margin-top: 6px;
}

.timeline-item {
    margin-bottom: 8px;
    position: relative;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 3px;
    width: 6px;
    height: 6px;
    background: #0d6efd;
    border-radius: 50%;
}

/* ===== EVITAR CORTES ===== */
* {
    page-break-inside: avoid;
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
         style="max-width:90px; max-height:90px; object-fit:contain;">
</td>

<td style="border:none; text-align:center; width:60%;">
    <h2 style="color:#0d6efd;">ORTHO CARE</h2>
    <p>
        Licenciado en Odontología – Cédula: <strong>8299663</strong><br>
        Especialidad en Ortodoncia y Ortopedia Maxilar – Cédula: <strong>12383864</strong><br>
        Tel: <strong>5510090611</strong>
    </p>
</td>

<td style="border:none; width:20%; text-align:right;">
    <strong>Fecha:</strong><br>
    {{ $fecha->format('d/m/Y') }}
</td>
</tr>
</table>

<hr>

<!-- ===== TITULO ===== -->
<div class="section" style="text-align:center;">
    <h3 style="color:#0d6efd;">TIMELINE CLÍNICO DE PROTESIS</h3>
</div>

<hr>

<!-- ===== PACIENTE ===== -->
<div class="section">
    <strong>Paciente:</strong> {{ $paciente->nombre }}<br>
    <strong>Edad:</strong> {{ $paciente->edad ?? '—' }}<br>
    <strong>Expediente:</strong> {{ $paciente->id }}
</div>

<hr>

<!-- ===== PRÓTESIS ===== -->
<div class="section">
    <strong>Tipo de Prótesis:</strong> {{ ucfirst($protesis->tipo) }}<br>
    <strong>Zona:</strong> {{ $protesis->zona ?? '—' }}<br>
    <strong>Inicio:</strong> {{ $protesis->fecha_inicio->format('d/m/Y') }}<br>
    <strong>Finalización:</strong> {{ $protesis->fecha_termino?->format('d/m/Y') ?? '—' }}<br>
    @if($protesis->observaciones)
        <strong>Observaciones:</strong> {{ $protesis->observaciones }}
    @endif
</div>

<hr>

<!-- ===== TIMELINE ===== -->
<div class="section">
<h3>Seguimiento Clínico</h3>

<div class="timeline">
@forelse($protesis->seguimientos as $seguimiento)
    <div class="timeline-item">
        <span class="badge">
             <strong>Etapa:</strong> {{ ucfirst($seguimiento->tipo_evento) }}
        </span>
        <div>
             <strong>Fecha:</strong> <strong> {{ $seguimiento->fecha->format('d/m/Y') }}</strong>
        </div>

        @if($seguimiento->descripcion)
            <div>
                 <strong>Observaciones:</strong> {{ $seguimiento->descripcion }}
            </div>
        @endif
    </div>
@empty
    <p class="text-muted">No hay registros de seguimiento.</p>
@endforelse
</div>
</div>

<!-- ===== AVISO LEGAL ===== -->
<hr>

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
