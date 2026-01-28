<!-- Modal Odontograma -->
<div class="modal fade" id="modalDiente" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formDiente" method="POST" action="{{ route('pacientes.evolucion.store', $paciente) }}">
        @csrf

        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">
            Diente: <span id="dienteSeleccionado"></span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body bg-light">
          <input type="hidden" name="diente" id="inputDiente">

          <label class="form-label">Estado</label>
          <select id="estadoDiente" name="estado" class="form-select">
            <option value="sano">Sano</option>
            <option value="caries">Caries</option>
            <option value="obturado">Obturado</option>
            <option value="endodoncia">Endodoncia</option>
            <option value="extraido">Extraído</option>
          </select>

          <label class="form-label mt-2">Observaciones</label>
          <textarea id="observacionesDiente" name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>
