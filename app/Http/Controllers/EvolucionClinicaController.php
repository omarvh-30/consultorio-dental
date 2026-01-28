<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\EvolucionClinica;
use Illuminate\Http\Request;

class EvolucionClinicaController extends Controller
{
    /**
     * Mostrar formulario de evolución clínica
     */
    public function create(Cita $cita)
    {
        // Solo permitir si la cita está atendida
        if ($cita->estado !== 'atendida') {
            return redirect()->route('citas.index')
                ->with('error', 'La cita aún no ha sido atendida');
        }

        // Si ya existe evolución, redirigir a edición (futuro)
        if ($cita->evolucion) {
            return redirect()->route('citas.show', $cita)
                ->with('info', 'Esta cita ya tiene evolución clínica');
        }

        return view('evolucion.create', compact('cita'));
    }

    /**
     * Guardar evolución clínica
     */
public function store(Request $request, Cita $cita)
{
    if ($cita->estado !== 'atendida') {
        return redirect()->route('citas.index');
    }

    $request->validate([
        'diagnostico' => 'required|string',
        'procedimiento' => 'required|string',
        'indicaciones' => 'nullable|string',
        'firma_base64' => 'required'
    ]);

    // 1. Guardar evolución
    $evolucion = EvolucionClinica::create([
        'cita_id' => $cita->id,
        'diagnostico' => $request->diagnostico,
        'procedimiento' => $request->procedimiento,
        'indicaciones' => $request->indicaciones,
    ]);

    // 2. Guardar firma
    $evolucion->firma()->create([
        'firma_base64' => $request->firma_base64
    ]);

    return redirect()->route('citas.show', $cita)
        ->with('success', 'Historia clínica registrada correctamente con firma');
}

}
