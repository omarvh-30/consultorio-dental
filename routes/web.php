<?php
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\EvolucionClinicaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacientePdfController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\OrtodonciaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

    // Recursos principales
    Route::resource('pacientes', PacienteController::class);
    Route::resource('citas', CitaController::class);

    // Evolución clínica
    Route::get('citas/{cita}/evolucion', [EvolucionClinicaController::class, 'create'])
        ->name('evolucion.create');

    Route::post('citas/{cita}/evolucion', [EvolucionClinicaController::class, 'store'])
        ->name('evolucion.store');

    Route::patch('citas/{cita}/atender',[CitaController::class, 'atender'])
        ->name('citas.atender');
    
    Route::patch('citas/{cita}/cancelar', [CitaController::class, 'cancelar'])
    ->name('citas.cancelar');


    // Historial
    Route::get('pacientes/{paciente}/historial', [PacienteController::class, 'historial'])
        ->name('pacientes.historial');

    // Calendario
    Route::get('calendario', [CitaController::class, 'calendario'])
        ->name('citas.calendario');

    Route::get('citas-json', [CitaController::class, 'citasJson'])
        ->name('citas.json');

    // Odontograma
    Route::get('pacientes/{paciente}/odontograma', [PacienteController::class, 'odontograma'])
        ->name('pacientes.odontograma');
    
    Route::post('/plan-tratamiento/guardar',[PacienteController::class, 'guardarPlan'])
        ->name('plan.guardar');

    Route::post('/plan/pago', [PacienteController::class, 'registrarPago'])
    ->name('plan.pago');

    Route::post('/plan/item/terminar',[PlanController::class, 'terminar'])
    ->name('plan.item.terminar');

    Route::post('/plan/finalizar', [PlanController::class, 'finalizarPlan'])
    ->name('plan.finalizar');

    // Guardar evolución del diente
    Route::post('odontograma/guardar', [PacienteController::class, 'guardarOdontograma'])
        ->name('odontograma.guardar');

    // PDF
    Route::get('pacientes/{paciente}/odontograma/pdf',[PacientePdfController::class, 'odontograma'])
        ->name('pacientes.odontograma.pdf');
    
    Route::get('/pacientes/{paciente}/plan/pdf',[PacientePdfController::class, 'planTratamiento'])
        ->name('pacientes.plan.pdf');

    Route::get('/ortodoncia/{ortodoncia}/timeline-pdf',[PacientePdfController::class, 'timelinePdf'])
        ->name('ortodoncia.timeline.pdf');

    Route::post('/plan/aceptar',[PlanController::class, 'aceptar'])
        ->name('plan.aceptar');

    // Ortodoncia
    Route::post('/ortodoncia/guardar', [OrtodonciaController::class, 'store'])
        ->name('ortodoncia.guardar');

    Route::post('/ortodoncia/cita/guardar', [OrtodonciaController::class, 'guardarCita'])
        ->name('ortodoncia.cita.guardar');

    Route::post('/ortodoncia/marcar-paso', [OrtodonciaController::class, 'marcarPaso'])
        ->name('ortodoncia.marcarPaso');

    // Dashboar
    Route::get('/buscar-pacientes', function () {
        return \App\Models\Paciente::select('id', 'nombre')
            ->where('nombre', 'like', '%'.request('q').'%')
            ->limit(10)
            ->get();
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');

    Route::get('/pacientes/{paciente}/expediente', [PacienteController::class, 'historial'])
        ->name('pacientes.expediente');

    Route::get('/citas/crear/{paciente}', [CitaController::class, 'create'])
    ->name('citas.create');


});

require __DIR__.'/auth.php';
