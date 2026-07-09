<?php

namespace App\Http\Controllers;

use App\Models\Limpieza;
use App\Models\Paciente;
use Illuminate\Http\Request;

class LimpiezaController extends Controller
{

    /**
     * Crear nuevo expediente de limpieza
     */
    public function store(Request $request, Paciente $paciente)
    {

        $request->validate([

            'fecha_inicio' => [
                'required',
                'date'
            ],

            'costo_total' => [
                'required',
                'numeric',
                'min:0'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],

        ]);



        // Evitar dos limpiezas activas al mismo tiempo
        $existeActiva = $paciente->limpiezas()
            ->where('estado', 'activa')
            ->exists();



        if($existeActiva){

            return back()->with(
                'error',
                'El paciente ya cuenta con un tratamiento de limpieza activo.'
            );

        }



        Limpieza::create([

            'paciente_id' => $paciente->id,

            'fecha_inicio' =>
                $request->fecha_inicio,

            'costo_total' =>
                $request->costo_total,

            'observaciones' =>
                $request->observaciones,

            'estado' =>
                'activa',

        ]);



        return back()->with(
            'success',
            'Tratamiento de limpieza creado correctamente.'
        );

    }



    /**
     * Actualizar expediente de limpieza
     */
    public function update(Request $request, Limpieza $limpieza)
    {

        $request->validate([

            'fecha_inicio' =>
                'required|date',

            'costo_total' =>
                'required|numeric|min:0',

            'observaciones' =>
                'nullable|string',

        ]);



        $limpieza->update([

            'fecha_inicio' =>
                $request->fecha_inicio,

            'costo_total' =>
                $request->costo_total,

            'observaciones' =>
                $request->observaciones,

        ]);



        return back()->with(
            'success',
            'Tratamiento de limpieza actualizado correctamente.'
        );

    }



    /**
     * Finalizar tratamiento de limpieza
     */
/**
 * Finalizar tratamiento de limpieza
 */
public function finalizar(Request $request, Limpieza $limpieza)
{

    $request->validate([

        'fecha_termino' =>
            'required|date',

    ]);



    // Verificar que exista al menos un seguimiento
    if($limpieza->seguimientos()->count() == 0){

        return back()->with(
            'error',
            'No se puede finalizar una limpieza sin seguimientos registrados.'
        );

    }



    // Calcular total pagado
    $totalPagado = $limpieza->seguimientos()
        ->sum('pago');



    // Verificar que el costo esté cubierto
    if($totalPagado < $limpieza->costo_total){

        $saldo = $limpieza->costo_total - $totalPagado;


        return back()->with(
            'error',
            'No se puede finalizar. La limpieza tiene un saldo pendiente de $'.number_format($saldo,2)
        );

    }



    $limpieza->update([

        'estado' =>
            'finalizada',

        'fecha_termino' =>
            $request->fecha_termino,

    ]);



    return back()->with(
        'success',
        'Tratamiento de limpieza finalizado correctamente.'
    );

}



    /**
     * Eliminar expediente completo
     */
    public function destroy(Limpieza $limpieza)
    {

        $limpieza->delete();



        return back()->with(
            'success',
            'Tratamiento de limpieza eliminado correctamente.'
        );

    }

}