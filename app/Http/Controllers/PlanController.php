<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentPlan;
use App\Models\TreatmentPlanItem;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Odontograma;

class PlanController extends Controller
{
    
    public function terminar(Request $request)
    {
        $item = TreatmentPlanItem::findOrFail($request->item_id);

        // 1️⃣ Marcar ítem como terminado
        $item->estatus = 'terminado';
        $item->save();

        // 2️⃣ Quitar el diente del próximo plan
        Odontograma::where([
            'paciente_id' => $item->plan->paciente_id,
            'diente' => $item->diente
        ])->update([
            'requiere_tratamiento' => false
        ]);

        // 3️⃣ Si el plan estaba aceptado, pasa a en_proceso
        $plan = $item->plan;
        if ($plan->estatus === 'aceptado') {
            $plan->estatus = 'en_proceso';
            $plan->save();
        }

        return back()->with('success', 'Tratamiento terminado');
    }

public function aceptar(Request $request)
{
    $request->validate([
        'plan_id'        => 'required|exists:treatment_plans,id',
        'firma_paciente' => 'required|string',
    ]);

    $plan = TreatmentPlan::findOrFail($request->plan_id);

    // 🔒 Evitar doble aceptación
    if ($plan->aceptado) {
        return back()->with('info', 'El plan ya fue aceptado');
    }

    $plan->aceptado = true;
    $plan->firma_paciente = $request->firma_paciente;
    $plan->fecha_aceptacion = now();
    $plan->estatus = 'aceptado';
    $plan->save();

    return back()->with('success', 'Plan aceptado correctamente');
}

public function finalizarPlan(Request $request)
{
    $request->validate([
        'plan_id' => 'required|exists:treatment_plans,id'
    ]);

    $plan = TreatmentPlan::with('items')->findOrFail($request->plan_id);

    // 🔒 Seguridad
    if (!$plan->aceptado) {
        return back()->with('error', 'El plan debe estar aceptado para finalizarse');
    }

    // 🔒 Validar que todos los items estén terminados
    $pendientes = $plan->items->where('estatus', 'pendiente')->count();

    if ($pendientes > 0) {
        return back()->with('error', 'Aún hay tratamientos pendientes');
    }

    // 🔒 Validar que no exista saldo pendiente
    if ($plan->saldo > 0) {
        return back()->with('error', 'No se puede finalizar el tratamiento con saldo pendiente');
    }

    $plan->estatus = 'finalizado';
    $plan->save();

    return back()->with('success', 'Tratamiento finalizado correctamente');
}


}
