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
    margin-bottom: 8px;
}

/* ===== TABLAS ===== */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9.5px;
}

th, td {
    border: 1px solid #999;
    padding: 4px;
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

/* ===== EVITAR CORTES ===== */
* {
    page-break-inside: avoid;
}
</style>
</head>

<body>

<div class="formato">

<!-- ===== ENCABEZADO ===== -->
<table style="border:none;">
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
    {{ now()->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
</td>
</tr>
</table>

<hr>

<!-- ===== TITULO DOCUMENTO ===== -->
<div class="section" style="text-align:center;">
    <h3 style="color:#0d6efd;">PLAN DE TRATAMIENTO ODONTOLÓGICO</h3>
</div>

<hr>

<!-- ===== DATOS PACIENTE ===== -->
<div class="section">
    <strong>Nombre del Paciente:</strong> {{ $paciente->nombre }}<br>
    <strong>Fecha de elaboración:</strong> {{ $fecha->format('d/m/Y') }}
</div>

<hr>

<!-- ===== RESUMEN FINANCIERO ===== -->
<div class="section">
<h3>Resumen Financiero</h3>

<table>
<thead>
<tr>
    <th>Total</th>
    <th>Pagado</th>
    <th>Saldo</th>
</tr>
</thead>
<tbody>
<tr>
    <td style="text-align:center;">
        ${{ number_format($plan->total,2) }}
    </td>
    <td style="text-align:center;">
        ${{ number_format($plan->pagado,2) }}
    </td>
    <td style="text-align:center;">
        ${{ number_format($plan->saldo,2) }}
    </td>
</tr>
</tbody>
</table>
</div>

<!-- ===== TRATAMIENTOS ===== -->
<div class="section">
<h3>Tratamientos por Diente</h3>

<table>
<thead>
<tr>
    <th width="15%">Diente</th>
    <th width="55%">Tratamiento</th>
    <th width="30%">Honorarios</th>
</tr>
</thead>
<tbody>
@foreach($plan->items as $i)
<tr>
    <td>{{ $i->diente }}</td>
    <td>{{ $i->tratamiento }}</td>
    <td>${{ number_format($i->precio_paciente,2) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<!-- ===== CONSENTIMIENTO ===== -->
@if($plan->aceptado && $plan->firma_paciente)

<hr>

<div class="section">
<h3>Consentimiento Informado</h3>

<p style="font-size:10px; text-align:justify;">
Yo, <strong>{{ $paciente->nombre }}</strong>, declaro haber recibido información
clara, suficiente y comprensible sobre el plan de tratamiento odontológico
propuesto, incluyendo procedimientos, beneficios, riesgos, alternativas
terapéuticas y costos asociados. Manifiesto mi aceptación voluntaria para la
realización del tratamiento descrito en el presente documento.
</p>

<p style="font-size:9px;">
<strong>Fecha de aceptación:</strong>
{{ $plan->fecha_aceptacion->format('d/m/Y') }}
</p>

<div style="margin-top:6px; text-align:center;">
    <img src="{{ $plan->firma_paciente }}" class="firma-img">
    <p style="font-size:9px; margin-top:2px;">Firma del paciente</p>
    <p style="font-size:8px; color:#0d6efd;">
        Firma digital validada – Expediente clínico odontológico
    </p>
</div>
</div>

@endif

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
