<div class="card shadow-soft mb-4">
    <div class="card-body">
        <div class="row g-3">

            {{-- Paciente --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Paciente *</label>
                <select name="paciente_id" class="form-select shadow-sm" required>
                    <option value="">Seleccione un paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}"
                            @selected(old('paciente_id', $cita->paciente_id ?? '') == $paciente->id)>
                            {{ $paciente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha y Hora --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Fecha y hora *</label>
                <input type="datetime-local" name="fecha_hora" class="form-control shadow-sm"
                    value="{{ old('fecha_hora', isset($cita) ? date('Y-m-d\TH:i', strtotime($cita->fecha_hora)) : '') }}"
                    required>
            </div>

            {{-- Motivo --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Motivo *</label>
                <input type="text" name="motivo" class="form-control shadow-sm"
                    value="{{ old('motivo', $cita->motivo ?? '') }}" required>
            </div>

            {{-- Observaciones --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea name="observaciones" class="form-control shadow-sm" rows="3">{{ old('observaciones', $cita->observaciones ?? '') }}</textarea>
            </div>

            {{-- Estado (solo si ya existe la cita) --}}
            @if(isset($cita))
            <div class="col-12">
                <label class="form-label fw-semibold">Estado</label>
                <select name="estado" class="form-select shadow-sm">
                    <option value="programada" @selected($cita->estado == 'programada')>Programada</option>
                    <option value="atendida" @selected($cita->estado == 'atendida')>Atendida</option>
                    <option value="cancelada" @selected($cita->estado == 'cancelada')>Cancelada</option>
                </select>
            </div>
            @endif

        </div>
    </div>
</div>
