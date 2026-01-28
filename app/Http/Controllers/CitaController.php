<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Listado de citas
     */
    public function index(Request $request)
    {
        $query = Cita::with('paciente');

        // 🔍 Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // 🔍 Filtro por paciente
        if ($request->filled('paciente')) {
            $query->whereHas('paciente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->paciente . '%');
            });
        }

        // 🔍 Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_hora', $request->fecha);
        }

        $citas = $query
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('citas.index', compact('citas'));
    }


    /**
     * Formulario de creación
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        return view('citas.create', compact('pacientes'));
    }

    /**
     * Guardar cita
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|max:255',
        ]);

        Cita::create([
            'paciente_id' => $request->paciente_id,
            'fecha_hora' => $request->fecha_hora,
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
            'estado' => 'programada',
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita registrada correctamente');
    }

    /**
     * Mostrar cita
     */
    public function show(Cita $cita)
    {
        $cita->load('paciente', 'evolucion.firma');

        return view('citas.show', compact('cita'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Cita $cita)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        return view('citas.edit', compact('cita', 'pacientes'));
    }

    /**
     * Actualizar cita
     */
    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:programada,atendida,cancelada',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada correctamente');
    }

    /**
     * Eliminar cita
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada correctamente');
    }
    
    public function calendario()
    {
        return view('citas.calendario');
    }

    public function citasJson()
    {
        $citas = Cita::with('paciente')->get();

        return response()->json(
            $citas->map(function ($cita) {
                return [
                    'id' => $cita->id,
                    'title' => $cita->paciente->nombre,
                    'start' => $cita->fecha_hora,
                    'color' => match ($cita->estado) {
                        'programada' => '#ffc107',
                        'atendida'   => '#198754',
                        'cancelada'  => '#dc3545',
                        default      => '#0d6efd',
                    },
                    'url' => route('citas.show', $cita->id),
                ];
            })
        );
    }

    public function atender(Cita $cita)
    {
        if ($cita->estado !== 'programada') {
            return back()->with('error', 'Solo se pueden atender citas programadas.');
        }

        $cita->update([
            'estado' => 'atendida'
        ]);

        return back()->with('success', 'La cita fue marcada como atendida.');
    }

    public function cancelar(Cita $cita)
    {  
    if ($cita->estado !== 'programada') {
        return redirect()->route('citas.index');
    }

    $cita->update([
        'estado' => 'cancelada'
    ]);

    return redirect()->route('citas.index')
        ->with('success', 'Cita cancelada correctamente');
    }

}
