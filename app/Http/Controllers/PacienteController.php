<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\Odontograma;
use App\Models\HistoriaOdontologica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TreatmentCatalog;
use App\Models\TreatmentPlan;
use App\Models\TreatmentPlanItem;
use App\Models\TreatmentPayment;


class PacienteController extends Controller
{
    /**
     * Mostrar listado de pacientes
     */
public function index(Request $request)
{
    $pacientes = Paciente::query()

        ->when($request->filled('nombre'), function ($query) use ($request) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        })

        ->when($request->filled('telefono'), function ($query) use ($request) {
            $query->where('telefono', 'like', '%' . $request->telefono . '%');
        })

        ->when($request->filled('email'), function ($query) use ($request) {
            $query->where('email', 'like', '%' . $request->email . '%');
        })

        ->orderBy('nombre')
        ->get();

    return view('pacientes.index', compact('pacientes'));
}

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Guardar paciente
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',

            'antecedentes_heredofamiliares' => 'nullable|string',
            'antecedentes_patologicos' => 'nullable|string',
            'antecedentes_no_patologicos' => 'nullable|string',

            'tratamiento_medico' => 'nullable|string',

            'enfermedades' => 'nullable|string',
            'traumatismos' => 'nullable|string',
            'transfusiones_cirugias' => 'nullable|string',

            'tipo_sangre' => 'nullable|string|max:10',

            'contacto_emergencia' => 'nullable|string|max:255',
            'telefono_emergencia' => 'nullable|string|max:50',

            'motivo_consulta' => 'nullable|string',
    ]);


        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente');
    }

    /**
     * Mostrar paciente
     */
    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualizar paciente
     */
    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
        'nombre' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:50',
        'email' => 'nullable|email',
        'fecha_nacimiento' => 'nullable|date',
        'sexo' => 'nullable|in:M,F',

        'antecedentes_heredofamiliares' => 'nullable|string',
        'antecedentes_patologicos' => 'nullable|string',
        'antecedentes_no_patologicos' => 'nullable|string',

        'tratamiento_medico' => 'nullable|string',

        'enfermedades' => 'nullable|string',
        'traumatismos' => 'nullable|string',
        'transfusiones_cirugias' => 'nullable|string',

        'tipo_sangre' => 'nullable|string|max:10',

        'contacto_emergencia' => 'nullable|string|max:255',
        'telefono_emergencia' => 'nullable|string|max:50',

        'motivo_consulta' => 'nullable|string',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente');
    }

    /**
     * Eliminar paciente
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente');
    }

    /**
     * Mostrar historial clínico completo del paciente
     */
    public function historial(Paciente $paciente)
    {
        // Cargar citas + evolución
        $paciente->load([
            'citas' => function ($q) {
                $q->orderBy('fecha_hora', 'desc');
            },
            'citas.evolucion'
        ]);

        return view('pacientes.historial', compact('paciente'));
    }
    /**
     * Mostrar odontograma
     */
public function odontograma(Paciente $paciente)
{
    // ===== LO QUE YA TENÍAS =====
    $odontograma = $paciente->odontograma->keyBy('diente');

    // Historia odontológica
    $historiaOdonto = HistoriaOdontologica::where('paciente_id', $paciente->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $superior = [
        18,17,16,15,14,13,12,11,
        21,22,23,24,25,26,27,28
    ];

    $inferior = [
        48,47,46,45,44,43,42,41,
        31,32,33,34,35,36,37,38
    ];


    // ===== 🟢 LO NUEVO DEL PLAN =====

    $dientesPlan = $paciente->odontograma
    ->where('requiere_tratamiento', true)
    ->pluck('estado','diente');

    $catalogo = TreatmentCatalog::all()
        ->groupBy('estado_asociado');
    // ===== 🟢 PLANES DEL PACIENTE =====

    // Todos los planes (histórico)
    $planes = TreatmentPlan::with(['items','pagos'])
        ->where('paciente_id', $paciente->id)
        ->orderByDesc('created_at')
        ->get();

    // Plan activo (NO finalizado)
    $planActivo = TreatmentPlan::where('paciente_id', $paciente->id)
    ->whereIn('estatus', ['borrador', 'aceptado', 'en_proceso'])
    ->latest()
    ->first();

    // ===== 🟢 LO QUE FALTABA (PARA WHATSAPP Y VISTA) =====

    $ultimaCita = $paciente->citas()
        ->whereNotIn('estado', ['cancelada','cancelado'])
        ->orderBy('fecha_hora','desc')
        ->first();

    $proximaCita = $paciente->citas()
        ->where('fecha_hora','>', now())
        ->orderBy('fecha_hora','asc')
        ->first();

    $planes = TreatmentPlan::with(['items', 'pagos'])
        ->where('paciente_id', $paciente->id)
        ->orderBy('created_at', 'desc')
        ->get();


    // ===== RETORNO =====
    return view('pacientes.odontograma', compact(
        'paciente',
        'odontograma',
        'superior',
        'inferior',
        'historiaOdonto',

        'dientesPlan',
        'catalogo',

        // 🟢 NUEVOS
        'planes',
        'planActivo',

        'ultimaCita',
        'proximaCita'
    ));

}




public function guardarOdontograma(Request $request)
{
    $validator = Validator::make($request->all(), [
        'paciente_id' => 'required|exists:pacientes,id',
        'diente' => 'required|string',
        'estado' => 'required|string',
        'observaciones' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Estado actual del diente
    Odontograma::updateOrCreate(
    [
        'paciente_id' => $request->paciente_id,
        'diente' => $request->diente,
    ],
    [
        'estado' => $request->estado,
        'requiere_tratamiento' => $request->estado !== 'extraido'
    ]
    );


    // Historia clínica (registro legal)
    HistoriaOdontologica::create([
        'paciente_id' => $request->paciente_id,
        'diente' => $request->diente,
        'estado' => $request->estado,
        'observaciones' => $request->observaciones,
        'fecha' => Carbon::now('America/Mexico_City')
    ]);

    return response()->json([
        'success' => true
    ]);
}

public function exportarPdf(Paciente $paciente)
{
    // Odontograma actual
    $odontograma = $paciente->odontograma->keyBy('diente');

    // Historia odontológica
    $historiaOdonto = HistoriaOdontologica::where('paciente_id', $paciente->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Última cita + evolución
    $ultimaCita = $paciente->citas()
        ->with(['evolucion.firma'])
        ->orderBy('fecha_hora', 'desc')
        ->first();


    $historiaOdonto = $historiaOdonto->map(function ($h) {
    $h->fecha = \Carbon\Carbon::parse($h->created_at)
        ->timezone('America/Mexico_City')
        ->format('d/m/Y H:i');
    return $h;
    });


    $pdf = Pdf::loadView(
        'pacientes.pdf.odontograma',
        compact('paciente', 'odontograma', 'historiaOdonto', 'ultimaCita')
    )
    ->setPaper('A4', 'portrait')
    ->setOption('isHtml5ParserEnabled', true)
    ->setOption('isRemoteEnabled', true);

    return $pdf->download(
        'Expediente_Odontologico_' . $paciente->nombre . '.pdf'
    );
}

public function guardarPlan(Request $request)
{
    $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'items' => 'required|array'
    ]);

    // 🔒 VALIDAR QUE NO EXISTA PLAN ACTIVO
    $planActivo = TreatmentPlan::where('paciente_id', $request->paciente_id)
    ->whereIn('estatus', ['borrador', 'aceptado', 'en_proceso'])
    ->first();


    if ($planActivo) {
        return back()->with('error',
            'El paciente ya tiene un plan activo. Finalízalo antes de crear uno nuevo.'
        );
    }


    // ✅ 1. CREAR PLAN (AQUÍ NACE $plan)
    $plan = TreatmentPlan::create([
        'paciente_id' => $request->paciente_id,
        'total' => 0,
        'pagado' => 0,
        'saldo' => 0,
        'estatus' => 'borrador',
        'aceptado' => false
    ]);


    $total = 0;

    // ✅ 2. GUARDAR ITEMS
    foreach ($request->items as $diente => $item) {

        if (empty($item['tratamiento'])) {
            continue;
        }

        TreatmentPlanItem::create([
            'treatment_plan_id' => $plan->id,

            // 🟢 Tomamos el diente desde la KEY del array
            'diente' => $diente,

            'tratamiento' => $item['tratamiento'],

            'precio_catalogo' =>
                $item['precio_catalogo'] ?? $item['precio_paciente'],

            'precio_paciente' =>
                $item['precio_paciente'] ?? $item['precio_catalogo']
        ]);

        $total += (float) $item['precio_paciente'];
    }


    // ✅ 3. ACTUALIZAR TOTALES
    $plan->update([
        'total' => $total,
        'saldo' => $total
    ]);

    // ✅ 4. REDIRECCIÓN CORRECTA
    return redirect()
        ->route('pacientes.odontograma', [
            'paciente' => $request->paciente_id
        ])
        ->with('success', 'Plan creado correctamente');
}

public function registrarPago(Request $request)
{
    $data = $request->validate([
        'plan_id' => 'required|exists:treatment_plans,id',
        'monto'   => 'required|numeric|min:1',
        'metodo'  => 'nullable|string',
        'nota'    => 'nullable|string'
    ]);

    $plan = TreatmentPlan::findOrFail($data['plan_id']);

    // 🚫 NO permitir pagos si el plan no está aceptado
    if (!$plan->aceptado) {
        return back()->with('error', 'El plan aún no ha sido aceptado');
    }

    // 🚫 VALIDACIÓN CLAVE: no pagar más del saldo
    if ($data['monto'] > $plan->saldo) {
        return back()->with('error',
            'El monto excede el saldo pendiente ($' . number_format($plan->saldo, 2) . ')'
        );
    }

    // 1️⃣ Registrar pago
    TreatmentPayment::create([
        'treatment_plan_id' => $plan->id,
        'monto'  => $data['monto'],
        'metodo' => $data['metodo'],
        'nota'   => $data['nota']
    ]);

    // 2️⃣ Recalcular pagos
    $pagado = $plan->pagos()->sum('monto');
    $saldo  = $plan->total - $pagado;

    // 3️⃣ Actualizar solo montos (NO tocar estatus)
    $plan->update([
        'pagado' => $pagado,
        'saldo'  => $saldo
    ]);


    return back()->with('success', 'Pago registrado correctamente');
}




}
