<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Protesis;
use App\Models\ProtesisSeguimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProtesisController extends Controller
{
    /**
     * Registrar nueva prótesis
     */
    public function store(Request $request, Paciente $paciente)
    {
        // 1️⃣ Validar
        $request->validate([
            'tipo' => 'required|in:superior,inferior,completa,parcial',
            'zona' => 'nullable|in:maxilar,mandibula,bimaxilar',
            'fecha_inicio' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        // 2️⃣ Bloquear si ya existe prótesis activa
        if ($paciente->protesisActiva) {
            return back()->with('error', 'El paciente ya tiene una prótesis activa.');
        }

        // 3️⃣ Crear prótesis
        Protesis::create([
            'paciente_id' => $paciente->id,
            'tipo' => $request->tipo,
            'zona' => $request->zona,
            'fecha_inicio' => $request->fecha_inicio,
            'estado' => 'en_proceso',
            'observaciones' => $request->observaciones,
        ]);

        // 4️⃣ Marcar paciente como prótesis
        if (!$paciente->es_protesis) {
            $paciente->update(['es_protesis' => 1]);
        }

        return back()->with('success', 'Prótesis registrada correctamente.');
    }

    /**
     * Finalizar prótesis activa
     */
    public function finalizar(Request $request, Protesis $protesis)
    {
        // 1️⃣ Validar
        $request->validate([
            'fecha_termino' => 'required|date|after_or_equal:' . $protesis->fecha_inicio,
            'observaciones' => 'nullable|string',
        ]);

        // 2️⃣ Validar estado
        if ($protesis->estado !== 'en_proceso') {
            return back()->with('error', 'Esta prótesis no está activa.');
        }

        // 3️⃣ Finalizar
        $protesis->update([
            'fecha_termino' => $request->fecha_termino,
            'estado' => 'finalizada',
            'observaciones' => $request->observaciones,
        ]);

        return back()->with('success', 'Prótesis finalizada correctamente.');
    }

    /**
     * Guardar seguimiento clínico
     */
    public function storeSeguimiento(Request $request, Protesis $protesis)
    {
        // 1️⃣ Validar
        $request->validate([
            'fecha' => 'required|date',
            'tipo_evento' => 'required|in:preparacion,impresion,provisional,prueba,ajuste,cementacion',
            'descripcion' => 'nullable|string',
        ]);

        // 2️⃣ Bloquear si no está activa
        if ($protesis->estado !== 'en_proceso') {
            return back()->with('error', 'No se pueden agregar seguimientos a una prótesis cerrada.');
        }

        // 3️⃣ Guardar seguimiento
        ProtesisSeguimiento::create([
            'protesis_id' => $protesis->id,
            'fecha' => $request->fecha,
            'tipo_evento' => $request->tipo_evento,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Seguimiento registrado.');
    }
}
