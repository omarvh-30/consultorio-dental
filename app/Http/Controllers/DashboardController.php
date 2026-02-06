<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Carbon\Carbon;
use App\Models\EvolucionClinica;


class DashboardController extends Controller
{
public function index()
{
    $hoy = \Carbon\Carbon::today();

    // ================= AGENDA DEL DÍA =================
    $citasHoy = \App\Models\Cita::with('paciente')
        ->whereDate('fecha_hora', $hoy)
        ->orderBy('fecha_hora')
        ->get();

    // ================= ALERTAS: EVOLUCIÓN PENDIENTE =================
    $alertasEvolucionPendiente = \App\Models\Cita::with('paciente')
        ->whereDate('fecha_hora', $hoy)
        ->where('estado', 'atendida')
        ->whereDoesntHave('evolucion') // 👈 relación correcta
        ->get();
    
    $citasPendientesHoy = Cita::with('paciente')
        ->whereDate('fecha_hora', today())
        ->whereIn('estado', ['programada'])
        ->get();

    // TOTAL PACIENTES
    $totalPacientes = Paciente::count();

    // CITAS HOY
    $citasHoyCount = Cita::whereDate('fecha_hora', Carbon::today())->count();

    // PRÓXIMA CITA
    $proximaCita = Cita::where('fecha_hora', '>', now())
        ->where('estado', 'programada')
        ->orderBy('fecha_hora')
        ->with('paciente')
        ->first();

    
    // ORTODONCIA ACTIVA
    $ortodonciaActiva = Paciente::where('es_ortodoncia', true)->count();

    // Contar pacientes con prótesis activa
    $protesisActiva = Paciente::where('es_protesis', true)->count();

    return view('dashboard', compact(
        'citasHoy',
        'alertasEvolucionPendiente',
        'citasPendientesHoy',
        'totalPacientes',
        'citasHoyCount',
        'proximaCita',
        'ortodonciaActiva',
        'protesisActiva'
    ));

}

}
