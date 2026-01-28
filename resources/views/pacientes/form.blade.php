{{-- ===== DATOS GENERALES ===== --}}
<div class="card shadow-soft mb-4">
    <div class="card-header bg-info bg-opacity-25 fw-semibold">
        <i class="bi bi-person-badge me-1"></i> Datos generales
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-control"
                    placeholder="Nombre completo del paciente"
                    value="{{ old('nombre', $paciente->nombre ?? '') }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control"
                    placeholder="Seleccione la fecha"
                    value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Sexo</label>
                <select name="sexo" class="form-select">
                    <option value="">Seleccione el sexo</option>
                    <option value="M" @selected(old('sexo', $paciente->sexo ?? '') == 'M')>Masculino</option>
                    <option value="F" @selected(old('sexo', $paciente->sexo ?? '') == 'F')>Femenino</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Teléfono</label>
                <input type="text" name="telefono" class="form-control"
                    placeholder="Ej: 999 123 456"
                    value="{{ old('telefono', $paciente->telefono ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                    placeholder="correo@ejemplo.com"
                    value="{{ old('email', $paciente->email ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Tipo de sangre</label>
                <select name="tipo_sangre" class="form-select">
                    <option value="">Seleccione tipo de sangre</option>
                    @foreach(['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $tipo)
                        <option value="{{ $tipo }}"
                            @selected(old('tipo_sangre', $paciente->tipo_sangre ?? '') == $tipo)>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>

{{-- ===== ANTECEDENTES MÉDICOS ===== --}}
<div class="card shadow-soft mb-4">
    <div class="card-header bg-info bg-opacity-25 fw-semibold">
        <i class="bi bi-heart-pulse me-1"></i> Antecedentes médicos
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Alergias</label>
                <textarea name="alergias" class="form-control" rows="2" placeholder="Ej: Penicilina, anestesia, alimentos">{{ old('alergias', $paciente->alergias ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Antecedentes heredofamiliares</label>
<textarea name="antecedentes_heredofamiliares" class="form-control" rows="2"
          placeholder="Ej: Diabetes, hipertensión, cáncer">{{ old('antecedentes_heredofamiliares', $paciente->antecedentes_heredofamiliares ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Antecedentes patológicos</label>
<textarea name="antecedentes_patologicos" class="form-control" rows="2"
          placeholder="Ej: Asma, epilepsia, cardiopatías">{{ old('antecedentes_patologicos', $paciente->antecedentes_patologicos ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Antecedentes no patológicos</label>
<textarea name="antecedentes_no_patologicos" class="form-control" rows="2"
          placeholder="Ej: Tabaquismo, alcohol, actividad física">{{ old('antecedentes_no_patologicos', $paciente->antecedentes_no_patologicos ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tratamiento médico / Medicamentos</label>
<textarea name="tratamiento_medico" class="form-control" rows="2"
          placeholder="Medicamentos actuales y dosis">{{ old('tratamiento_medico', $paciente->tratamiento_medico ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Enfermedades relevantes</label>
<textarea name="enfermedades" class="form-control" rows="2"
          placeholder="Enfermedades relevantes actuales o pasadas">{{ old('enfermedades', $paciente->enfermedades ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Traumatismos</label>
<textarea name="traumatismos" class="form-control" rows="2"
          placeholder="Fracturas, golpes importantes">{{ old('traumatismos', $paciente->traumatismos ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Transfusiones / Cirugías</label>
<textarea name="transfusiones_cirugias" class="form-control" rows="2"
          placeholder="Cirugías previas o transfusiones">{{ old('transfusiones_cirugias', $paciente->transfusiones_cirugias ?? '') }}</textarea>            </div>

        </div>
    </div>
</div>

{{-- ===== CONTACTO Y MOTIVO ===== --}}
<div class="card shadow-soft mb-4">
    <div class="card-header bg-info bg-opacity-25 fw-semibold">
        <i class="bi bi-telephone-forward me-1"></i> Contacto y motivo de consulta
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Contacto de emergencia</label>
                <input type="text" name="contacto_emergencia" class="form-control" placeholder="Nombre del contacto"
                       value="{{ old('contacto_emergencia', $paciente->contacto_emergencia ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Teléfono de emergencia</label>
                <input type="text" name="telefono_emergencia" class="form-control" placeholder="Teléfono del contacto"
                       value="{{ old('telefono_emergencia', $paciente->telefono_emergencia ?? '') }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Motivo de consulta</label>
                <textarea name="motivo_consulta" class="form-control" placeholder="Describa el motivo principal de la consulta" rows="2">{{ old('motivo_consulta', $paciente->motivo_consulta ?? '') }}</textarea>
            </div>

        </div>
    </div>
</div>

{{-- ===== TIPO DE PACIENTE ===== --}}
<div class="card shadow-soft mb-4">
    <div class="card-body">
        <input type="hidden" name="es_ortodoncia" value="0">

        <div class="form-check form-switch">
            <input class="form-check-input"
                   type="checkbox"
                   name="es_ortodoncia"
                   id="es_ortodoncia"
                   value="1"
                   {{ old('es_ortodoncia', $paciente->es_ortodoncia ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="es_ortodoncia">
                Paciente de Ortodoncia
            </label>
        </div>
    </div>
</div>
