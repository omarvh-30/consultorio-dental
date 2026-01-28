<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    margin: 15px 20px;
}

/* ===== CONTENEDOR TIPO FORMATO ===== */
.formato {
    border: 2px solid #0d6efd;
    padding: 10px;
    border-radius: 8px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #222;
    line-height: 1.15;
}

h2 { font-size: 13px; margin-bottom: 3px; }
h3 { font-size: 12px; margin-bottom: 3px; }

.section {
    margin-bottom: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9.5px;
}

th, td {
    border: 1px solid #999;
    padding: 3px;
}

th { background: #f0f0f0; }

p { margin: 2px 0; }

/* Estados odontograma */
.estado-sano { color: #198754; }
.estado-caries { color: #dc3545; }
.estado-obturado { color: #0d6efd; }
.estado-endodoncia { color: #fd7e14; }
.estado-extraido { color: #212529; }

/* Evitar saltos */
* { page-break-inside: avoid; }
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

<!-- ===== ALERTA ORTODONCIA ===== -->
@if($paciente->es_ortodoncia)
<div style="
    background:#e7f1ff;
    border:2px solid #0d6efd;
    padding:6px;
    border-radius:6px;
    margin-bottom:6px;
    text-align:center;
">
    <h3 style="color:#0d6efd; margin:0;">
        🦷 PACIENTE EN TRATAMIENTO DE ORTODONCIA
    </h3>
</div>
@endif

<!-- ===== DATOS PACIENTE ===== -->
<div class="section">
<strong>Nombre del Paciente:  </strong> {{ $paciente->nombre }} 
<br>
</div>

<hr>

<!-- ===== ODONTOGRAMA ===== -->
<div class="section">
<h3>Odontograma Actual</h3>

@if(isset($odontogramaImg) && file_exists($odontogramaImg))
<div style="margin-bottom: 6px; text-align: center;">
    <img src="file://{{ $odontogramaImg }}"
         style="width: 100%; max-width: 480px;">
</div>
@endif
</div>

<!-- ===== HISTORIA ===== -->
<div class="section">
<h3>Historia Odontológica</h3>

<table>
<thead>
<tr>
    <th>Fecha</th>
    <th>Diente</th>
    <th>Estado</th>
    <th>Observaciones</th>
</tr>
</thead>
<tbody>

@if($historiaOdonto && $historiaOdonto->count())
@foreach($historiaOdonto as $h)
<tr>
<td>{{ $h->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}</td>
<td>{{ $h->diente }}</td>
<td class="estado-{{ $h->estado }}">
    {{ ucfirst($h->estado) }}
</td>
<td>{{ $h->observaciones ?? '—' }}</td>
</tr>
@endforeach
@else
<tr>
<td colspan="4">Sin movimientos odontológicos</td>
</tr>
@endif

</tbody>
</table>
</div>

<!-- ===== ÚLTIMA CITA ===== -->
@if($ultimaCita)
<div class="section">

<h3>Última Cita Atendida</h3>

<strong>Fecha:</strong>
{{ $ultimaCita->fecha_hora
    ->timezone('America/Mexico_City')
    ->format('d/m/Y H:i') }}

@if($ultimaCita->evolucion)

<p><strong>Diagnóstico:</strong><br>
{{ $ultimaCita->evolucion->diagnostico }}</p>

<p><strong>Procedimiento:</strong><br>
{{ $ultimaCita->evolucion->procedimiento }}</p>

<p><strong>Indicaciones:</strong><br>
{{ $ultimaCita->evolucion->indicaciones }}</p>

@endif
</div>
@endif

<!-- ===== CONSENTIMIENTO Y FIRMA ===== -->
@if($ultimaCita && $ultimaCita->evolucion)

<div style="page-break-inside: avoid;">

<hr>

<h3>Consentimiento del Paciente</h3>

<p style="font-size:10px; text-align:justify;">
Yo, paciente, acepto el tratamiento y la evolución descrita por el profesional,
habiendo sido informado de los procedimientos realizados, beneficios,
riesgos y alternativas terapéuticas.
</p>

@if($ultimaCita->evolucion->firma)

<div style="margin-top:6px; text-align:center;">

<img src="{{ $ultimaCita->evolucion->firma->firma_base64 }}"
     style="
        max-width:180px;
        max-height:75px;
        border:1px solid #ccc;
        padding:3px;
     ">

<p style="font-size:9px; margin-top:2px;">
Firma del paciente
</p>

<p style="font-size:8px; color:#0d6efd;">
Firma digital validada – Expediente clínico odontológico
</p>

</div>

@endif
</div>

@endif

<!-- ===== AVISO DE PRIVACIDAD ===== -->
<hr>

<p style="font-size:8px; text-align:justify; color:#555;">
<strong>Aviso de Privacidad:</strong>  
Los datos personales, clínicos y financieros contenidos en este documento son tratados de forma confidencial por <strong>ORTHO CARE</strong> para fines de diagnóstico, tratamiento, seguimiento y control administrativo, de acuerdo con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares. La información aquí contenida tiene carácter confidencial y, en su caso, validez clínica y legal conforme a la normatividad sanitaria vigente.
</p>

<p style="font-size:8px; text-align:center; color:#0d6efd;">
Documento generado electrónicamente · ORTHO CARE · Expediente Clínico
</p>

</div><!-- fin formato -->

</body>
</html>
