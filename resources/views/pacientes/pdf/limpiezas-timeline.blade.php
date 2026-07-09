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
        /* TITULOS */
        h2 {
            font-size: 13px;
            margin-bottom: 3px;
        }
        h3 {
            font-size: 12px;
            margin-bottom: 4px;
            color: #0d6efd;
        }
        /* SECCIONES */
        .section {
            margin-bottom: 8px;
        }
        /* TEXTO */
        .text-muted {
            color: #555;
            font-size: 9px;
        }
        /* BADGE */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8.5px;
            border-radius: 10px;
            background: #d1e7dd;
            color: #146c43;
            font-weight: bold;
        }
        /* TIMELINE */
        .timeline {
            border-left: 2px solid #0d6efd;
            padding-left: 12px;
            margin-top: 6px;
        }
        .timeline-item {
            margin-bottom: 10px;
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
        /* EVITAR CORTES */
        * {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="formato">
        <!-- ================= ENCABEZADO ================= -->
        <table style="border:none;width:100%;">
            <tr>
                <td style="border:none;width:20%;text-align:center;">
                    <img src="{{ public_path('images/logo.png') }}"
                        style="max-width:90px;max-height:90px;object-fit:contain;">
                </td>
                <td style="border:none;text-align:center;width:60%;">
                    <h2 style="color:#0d6efd;">
                        ORTHO CARE
                    </h2>
                    <p>
                        Licenciado en Odontología – Cédula:
                        <strong>8299663</strong><br>
                        Especialidad en Ortodoncia y Ortopedia Maxilar –
                        Cédula:
                        <strong>12383864</strong><br>
                        Tel:
                        <strong>5510090611</strong>
                    </p>
                </td>
                <td style="border:none;width:20%;text-align:right;">
                    <strong>Fecha:</strong><br>
                    {{ $fecha->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <hr>
        <!-- ================= TITULO ================= -->
        <div class="section" style="text-align:center;">
            <h3>
                TIMELINE CLÍNICO DE LIMPIEZA DENTAL
            </h3>
        </div>
        <hr>
        <!-- ================= PACIENTE ================= -->
        <div class="section">
            <strong>Paciente:</strong>
            {{ $paciente->nombre }}
            <br>
            <strong>Edad:</strong>
            {{ $paciente->edad ?? '—' }}
            <br>
        </div>
        <hr>
        <!-- ================= EXPEDIENTE LIMPIEZA ================= -->
        <div class="section">
            <h3>
                Datos del tratamiento
            </h3>
            <strong>Inicio:</strong>
            {{ $limpieza->fecha_inicio->format('d/m/Y') }}
            <br>
            <strong>Finalización:</strong>
            {{ $limpieza->fecha_termino?->format('d/m/Y') ?? '—' }}
            <br>
            <strong>Estado:</strong>
            <span class="badge">
                {{ ucfirst($limpieza->estado) }}
            </span>
            <br>
            <strong>Costo total:</strong>
            ${{ number_format($limpieza->costo_total, 2) }}
            <br>
            <strong>Total aplicado:</strong>
            ${{ number_format($totalAplicado, 2) }}
            <br>
            <strong>Pendiente:</strong>
            ${{ number_format($pendiente, 2) }}
            <br>
            @if($limpieza->observaciones)
                <strong>Observaciones:</strong>
                {{ $limpieza->observaciones }}
            @endif
        </div>
        <hr>
        <!-- ================= SEGUIMIENTOS ================= -->
        <div class="section">
            <h3>
                Seguimiento Clínico
            </h3>
            <div class="timeline">
                @forelse($limpieza->seguimientos as $seguimiento)
                <div class="timeline-item">
                    <table style="width:100%;border:none;border-collapse:collapse;">
                        <tr>
                            {{-- INFORMACIÓN --}}
                            <td style="width:75%;vertical-align:top;border:none;padding-right:10px;">
                                <span class="badge">
                                    {{ $seguimiento->catalogo->nombre ?? 'Servicio' }}
                                </span>
                                <div>
                                    <strong>Fecha:</strong>
                                    {{ $seguimiento->fecha->format('d/m/Y') }}
                                </div>
                                <div>
                                    <strong>Pago realizado:</strong>
                                    ${{ number_format($seguimiento->pago, 2) }}
                                </div>
                                @if($seguimiento->proxima_cita)
                                    <div>
                                        <strong>Próxima cita:</strong>
                                        {{ $seguimiento->proxima_cita->format('d/m/Y') }}
                                    </div>
                                @endif
                                @if($seguimiento->observaciones)
                                    <div>
                                        <strong>Observaciones:</strong>
                                        {{ $seguimiento->observaciones }}
                                    </div>
                                @endif
                            </td>
                            {{-- FIRMA --}}
                            <td style="width:25%;border:none;text-align:center;vertical-align:top;">
                                @if($seguimiento->firma)
                                    <strong style="font-size:9px;">
                                        Firma de conformidad
                                    </strong>
                                    <br><br>
                                    <img
                                        src="{{ $seguimiento->firma }}"
                                        style="width:120px;height:auto;border:1px solid #bbb;padding:4px;border-radius:4px;">
                                @endif
                            </td>
                        </tr>
                                                    <hr style="border:none;border-top:1px solid #bbb;margin:10px 0;">

                    </table>
                </div>
                @empty
                    <p class="text-muted">
                        No hay registros de seguimiento.
                    </p>
                @endforelse
            </div>
        </div>
        <hr>
        <!-- ================= AVISO ================= -->
        <p style="font-size:8px;text-align:justify;color:#555;">
            <strong>Aviso de Privacidad:</strong>

            Los datos personales, clínicos y financieros contenidos en este documento son tratados de forma confidencial por
            <strong>ORTHO CARE</strong> para fines de diagnóstico, tratamiento, seguimiento y control administrativo, de acuerdo con la
            Ley Federal de Protección de Datos Personales en Posesión de los Particulares.

            La información aquí contenida tiene carácter confidencial y, en su caso, validez clínica y legal conforme a la
            normatividad sanitaria vigente.
        </p>
        <p style="font-size:8px;text-align:center;color:#0d6efd;">
            Documento generado electrónicamente · ORTHO CARE · Expediente Clínico
        </p>
    </div>
</body>

</html>

