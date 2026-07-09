<?php

namespace App\Http\Controllers;
use App\Models\Limpieza;
use App\Models\LimpiezaSeguimiento;
use Illuminate\Http\Request;

class LimpiezaSeguimientoController extends Controller
{
    /**
     * Registrar nuevo seguimiento de limpieza
     */
    public function store(Request $request, Limpieza $limpieza)
    {
        // Validación
        $request->validate([
            'catalogo_limpieza_id' => [
                'required',
                'exists:catalogo_limpiezas,id'
            ],
            'fecha' => [
                'required',
                'date'
            ],
            'pago' => [
                'required',
                'numeric',
                'min:0'
            ],
            'observaciones' => [
                'nullable',
                'string'
            ],
            'proxima_cita' => [
                'nullable',
                'date'
            ],
            'firma' => [
                'required',
                'string'
            ],
        ]);
        // No permitir agregar seguimientos a una limpieza finalizada
        if ($limpieza->estado === 'finalizada') {
            return back()->with(
                'error',
                'La limpieza ya está finalizada.'
            );
        }
        // Validar que el pago no supere el saldo pendiente
        $saldoPendiente = $limpieza->costo_total -
            $limpieza->seguimientos()->sum('pago');
        if ($request->pago > $saldoPendiente) {
            return back()->with(
                'error',
                'El pago no puede ser mayor al saldo pendiente.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Crear seguimiento
        |--------------------------------------------------------------------------
        */
        LimpiezaSeguimiento::create([
            'limpieza_id' => $limpieza->id,
            'catalogo_limpieza_id' =>
                $request->catalogo_limpieza_id,
            'fecha' =>
                $request->fecha,
            'pago' =>
                $request->pago,
            'observaciones' =>
                $request->observaciones,
            'proxima_cita' =>
                $request->proxima_cita,
            // Se almacena directamente el Base64
            'firma' =>
                $request->firma,
        ]);
        /*
        |--------------------------------------------------------------------------
        | Actualizar estado si corresponde
        |--------------------------------------------------------------------------
        */
        $totalPagado = $limpieza->seguimientos()
            ->sum('pago')
            +
            $request->pago;
        if ($totalPagado >= $limpieza->costo_total) {
            $limpieza->update([
                'estado' => 'finalizada',
                'fecha_termino' => now()
            ]);

        }
        return back()->with(
            'success',
            'Seguimiento registrado correctamente.'
        );

    }
    /**
     * Mostrar seguimiento
     */
    public function show(LimpiezaSeguimiento $seguimiento)
    {
        return view(
            'pacientes.limpiezas.show',
            compact('seguimiento')
        );

    }
    /**
     * Eliminar seguimiento
     */
    public function destroy(LimpiezaSeguimiento $seguimiento)
    {
        $seguimiento->delete();
        return back()->with(
            'success',
            'Seguimiento eliminado correctamente.'
        );
    }

}