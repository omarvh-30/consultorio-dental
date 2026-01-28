<?php

namespace App\Http\Controllers;

use App\Models\Ortodoncia;
use App\Models\OrtodonciaCita;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrtodonciaController extends Controller
{
    /* =====================================================
        GUARDAR CONFIGURACIÓN INICIAL DE ORTODONCIA
       ===================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'   => 'required|exists:pacientes,id',
            'tipo_brackets' => 'required|string',
            'fecha_inicio'  => 'required|date',
            'diagnostico'   => 'nullable|string',
        ]);

        // Evitar duplicados
        $paciente = Paciente::findOrFail($request->paciente_id);

        if ($paciente->ortodoncia) {
            return back()->with('error', 'Este paciente ya tiene un tratamiento de ortodoncia.');
        }

        Ortodoncia::create([
            'paciente_id'   => $paciente->id,
            'tipo_brackets' => $request->tipo_brackets,
            'fecha_inicio'  => $request->fecha_inicio,
            'diagnostico'   => $request->diagnostico,
            'estado'        => 'activo',
        ]);

        return back()->with('success', 'Tratamiento de ortodoncia iniciado correctamente.');
    }

    /* =====================================================
        MARCAR PASOS CLÍNICOS DEL FLUJO
       ===================================================== */
public function marcarPaso(Request $request)
{
    $request->validate([
        'ortodoncia_id' => 'required|exists:ortodoncias,id',
        'campo'         => 'required|string',
    ]);

    $ortodoncia = Ortodoncia::findOrFail($request->ortodoncia_id);

    $camposPermitidos = [
        'fecha_profilaxis',
        'fecha_colocacion',
        'fecha_retiro',
        'fecha_retenedores',
        'fecha_fin',
    ];

    if (!in_array($request->campo, $camposPermitidos)) {
        return back()->with('error', 'Acción no permitida.');
    }

    /* ===============================
       VALIDACIONES DE ORDEN CLÍNICO
    ================================ */

    if ($request->campo === 'fecha_profilaxis' && !$ortodoncia->diagnostico) {
        return back()->with('error', 'Debe registrar el diagnóstico antes de la profilaxis.');
    }

    if ($request->campo === 'fecha_colocacion' && !$ortodoncia->fecha_profilaxis) {
        return back()->with('error', 'Debe realizar la profilaxis antes de colocar brackets.');
    }

    if ($request->campo === 'fecha_retiro' && !$ortodoncia->fecha_colocacion) {
        return back()->with('error', 'No puede retirar brackets sin haberlos colocado.');
    }

    if ($request->campo === 'fecha_retenedores' && !$ortodoncia->fecha_retiro) {
        return back()->with('error', 'Debe retirar los brackets antes de colocar retenedores.');
    }

    if ($request->campo === 'fecha_fin' && !$ortodoncia->fecha_retenedores) {
        return back()->with('error', 'Debe colocar retenedores antes de finalizar el tratamiento.');
    }

    /* ===============================
       REGISTRAR EL PASO
    ================================ */

    $ortodoncia->{$request->campo} = now();

    // Solo aquí se cambia el estado general
    if ($request->campo === 'fecha_fin') {
        $ortodoncia->estado = 'finalizado';
    }

    $ortodoncia->save();

    return back()->with('success', 'Paso clínico actualizado correctamente.');
}



    /* =====================================================
        GUARDAR CITA (ARCOS)
       ===================================================== */
public function guardarCita(Request $request)
{
    $request->validate([
        'ortodoncia_id' => 'required|exists:ortodoncias,id',
        'arco_superior' => 'nullable|string|max:10',
        'arco_inferior' => 'nullable|string|max:10',
    ]);

    $ortodoncia = Ortodoncia::findOrFail($request->ortodoncia_id);

    /* =====================================================
        VALIDACIONES CLÍNICAS OBLIGATORIAS
       ===================================================== */

    // Tratamiento finalizado
    if ($ortodoncia->estado === 'finalizado') {
        return back()->with('error', 'El tratamiento ya está finalizado.');
    }

    // Paso 1: Diagnóstico
    if (!$ortodoncia->diagnostico) {
        return back()->with('error', 'Debe registrar el diagnóstico antes de iniciar el seguimiento.');
    }

    // Paso 2: Profilaxis
    if (!$ortodoncia->fecha_profilaxis) {
        return back()->with('error', 'Debe realizar la profilaxis antes de registrar citas.');
    }

    // Paso 3: Colocación de brackets (🔑 ESTO ACTIVA EL SEGUIMIENTO)
    if (!$ortodoncia->fecha_colocacion) {
        return back()->with('error', 'Debe colocar los brackets antes de registrar citas.');
    }

    // Al menos un arco
    if (!$request->arco_superior && !$request->arco_inferior) {
        return back()->with('error', 'Debe registrar al menos un arco.');
    }
    if ($ortodoncia->fecha_retiro) {
    return back()->with('error', 'El tratamiento ya está en fase de retiro.');
    }


    /* =====================================================
        REGISTRO DE CITA
       ===================================================== */

    OrtodonciaCita::create([
        'ortodoncia_id' => $ortodoncia->id,
        'arco_superior' => $request->arco_superior,
        'arco_inferior' => $request->arco_inferior,
    ]);

    return back()->with('success', 'Cita de ortodoncia registrada correctamente.');
}

}
