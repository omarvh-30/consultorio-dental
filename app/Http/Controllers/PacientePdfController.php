<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\HistoriaOdontologica;
use App\Models\TreatmentPlan;
use App\Models\Ortodoncia;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Models\Protesis;
use App\Models\Limpieza;

class PacientePdfController extends Controller
{
    /* =========================================================
     | UTILIDAD COMÚN PARA STREAM / DOWNLOAD
     ========================================================= */
    private function renderPdf($pdf, string $nombre)
    {
        if (request('view')) {
            return $pdf->stream($nombre);
        }

        return $pdf->download($nombre);
    }

    /* =========================================================
     | PDF EXPEDIENTE / ODONTOGRAMA
     ========================================================= */
    public function odontograma(Paciente $paciente)
    {
        // 1️⃣ Historia odontológica
        $historiaOdonto = HistoriaOdontologica::where('paciente_id', $paciente->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('diente');

        // 2️⃣ Estado actual por diente
        $odontograma = $historiaOdonto->keyBy('diente');

        // 3️⃣ Última cita válida
        $ultimaCita = $paciente->citas()
            ->with('evolucion')
            ->whereNotIn('estado', ['cancelada', 'cancelado'])
            ->orderBy('fecha_hora', 'desc')
            ->first();

        // 4️⃣ Render SVG → PNG
        $html = view('pacientes.pdf.partials.odontograma-svg', [
            'odontograma' => $odontograma,
            'paciente'    => $paciente,
        ])->render();

        $path = "temp/odontograma_{$paciente->id}.png";

        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0755, true);
        }

        Browsershot::html($html)
            ->setNodeBinary('/usr/bin/node')
            ->setNpmBinary('/usr/bin/npm')
            ->setChromePath('/usr/bin/chromium')
            ->noSandbox()
            ->windowSize(1000, 450)
            ->transparentBackground()
            ->save(storage_path("app/public/{$path}"));


        // 5️⃣ PDF
        $pdf = Pdf::loadView('pacientes.pdf.odontograma', [
            'paciente'       => $paciente,
            'odontograma'    => $odontograma,
            'historiaOdonto' => $historiaOdonto,
            'ultimaCita'     => $ultimaCita,
            'odontogramaImg' => storage_path("app/public/{$path}")
        ]);

        $nombre = 'Expediente_Odontologico_' . $paciente->nombre . '.pdf';

        return $this->renderPdf($pdf, $nombre);
    }

    /* =========================================================
     | PDF PLAN DE TRATAMIENTO (ACTIVO O HISTÓRICO)
     ========================================================= */
    public function planTratamiento(Paciente $paciente)
    {
        $planId = request('plan');

        $query = TreatmentPlan::with(['items', 'pagos'])
            ->where('paciente_id', $paciente->id);

        // 📌 Plan específico (histórico)
        if ($planId) {
            $query->where('id', $planId);
        }
        // 📌 Plan activo
        else {
            $query->activo()->orderByDesc('id');
        }

        $plan = $query->first();

        if (!$plan) {
            return back()->with('error', 'El paciente no tiene plan de tratamiento');
        }

        $pdf = Pdf::loadView('pacientes.pdf.plan-tratamiento', [
            'paciente' => $paciente,
            'plan'     => $plan,
            'fecha'    => now(),
        ]);

        $nombre = 'Plan_Tratamiento_' . $paciente->nombre . '.pdf';

        return $this->renderPdf($pdf, $nombre);
    }

    /* =========================================================
     | PDF TIMELINE ORTODONCIA
     ========================================================= */
    public function timelinePdf(Ortodoncia $ortodoncia)
    {
        $ortodoncia->load(['paciente', 'citas']);

        $pdf = Pdf::loadView('pacientes.pdf.ortodoncia-timeline', [
            'ortodoncia' => $ortodoncia
        ])->setPaper('a4', 'portrait');

        $nombre = 'Timeline_Ortodoncia_' . $ortodoncia->paciente->nombre . '.pdf';

        return $this->renderPdf($pdf, $nombre);
    }

    /* =========================================================
 | PDF TIMELINE PRÓTESIS
 ========================================================= */
public function protesisTimelinePdf(Protesis $protesis)
{
    // 🔒 Cargar relaciones necesarias
    $protesis->load([
        'paciente',
        'seguimientos'
    ]);

    // 🧠 Detectar tipo de PDF
    $esParcial = $protesis->estado !== 'finalizada';

    // 📄 Generar PDF
    $pdf = Pdf::loadView('pacientes.pdf.protesis-timeline', [
        'protesis'  => $protesis,
        'paciente'  => $protesis->paciente,
        'fecha'     => now(),
        'esParcial' => $esParcial,
    ])->setPaper('a4', 'portrait');

    // 📎 Nombre dinámico
    $estado = $esParcial ? 'Parcial' : 'Final';
    $nombre = "Timeline_Protesis_{$estado}_{$protesis->paciente->nombre}.pdf";

    return $this->renderPdf($pdf, $nombre);
}

/* =========================================================
 | PDF TIMELINE LIMPIEZAS
 ========================================================= */
public function limpiezasTimelinePdf(Limpieza $limpieza)
{

    // 🔒 Cargar relaciones necesarias
    $limpieza->load([
        'paciente',
        'seguimientos.catalogo'
    ]);


    // 💰 Calcular totales reales cobrados
    $totalAplicado = $limpieza->seguimientos
        ->sum('pago');


    $pendiente = max(
        0,
        $limpieza->costo_total - $totalAplicado
    );



    // 📄 Generar PDF
    $pdf = Pdf::loadView('pacientes.pdf.limpiezas-timeline', [

        'limpieza'      => $limpieza,

        'paciente'      => $limpieza->paciente,

        'totalAplicado' => $totalAplicado,

        'pendiente'     => $pendiente,

        'fecha'         => now(),

    ])->setPaper('a4', 'portrait');



    // 📎 Nombre dinámico

    $nombre = 'Timeline_Limpieza_' .
        $limpieza->paciente->nombre .
        '.pdf';



    return $this->renderPdf($pdf, $nombre);

}


}
