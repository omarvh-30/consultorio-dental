document.addEventListener('DOMContentLoaded', function () {
    // --- MODAL DIENTE ---
    const modalEl = document.getElementById('modalDiente');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);

        const dienteSeleccionadoSpan = document.getElementById('dienteSeleccionado');
        const inputDiente = document.getElementById('inputDiente');
        const estadoSelect = document.getElementById('estadoDiente');
        const observacionesTextarea = document.getElementById('observacionesDiente');
        const formDiente = document.getElementById('formDiente');

        // Popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Click en un diente para abrir modal
        const dientes = document.querySelectorAll('.odontograma-svg .diente');
        if (dientes.length) {
            dientes.forEach(diente => {
                diente.addEventListener('click', function () {
                    const dienteId = this.dataset.diente;

                    if(dienteSeleccionadoSpan) dienteSeleccionadoSpan.textContent = dienteId;
                    if(inputDiente) inputDiente.value = dienteId;

                    // Selecciona el estado según la clase del SVG
                    if (estadoSelect) {
                        estadoSelect.value = this.classList.contains('sano') ? 'sano' :
                                             this.classList.contains('caries') ? 'caries' :
                                             this.classList.contains('obturado') ? 'obturado' :
                                             this.classList.contains('endodoncia') ? 'endodoncia' :
                                             this.classList.contains('extraido') ? 'extraido' : 'sano';
                    }

                    if(observacionesTextarea) observacionesTextarea.value = '';
                    modal.show();
                });
            });
        }

        // Submit único: usar un flag para evitar doble ejecución
        if (formDiente) {
            formDiente.onsubmit = async function (e) {
                e.preventDefault();
                if (formDiente.dataset.enviando === "1") return;
                formDiente.dataset.enviando = "1";

                const formData = new FormData(formDiente);

                try {
                    const res = await fetch(formDiente.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await res.json();
                    formDiente.dataset.enviando = "0";

                    if (data.success) {
                        const dienteId = inputDiente ? inputDiente.value : null;
                        if(dienteId){
                            const dienteSvg = document.getElementById('diente-' + dienteId);
                            if (dienteSvg && estadoSelect) {
                                dienteSvg.className.baseVal = 'diente ' + estadoSelect.value;
                            }
                        }

                        modal.hide();
                        formDiente.reset();
                        location.reload();
                    } else {
                        alert('Error al guardar: ' + JSON.stringify(data.errors));
                    }

                } catch (err) {
                    formDiente.dataset.enviando = "0";
                    console.error(err);
                    alert('Error inesperado al guardar el diente.');
                }
            };
        }
    }

    // --- FILTRO DE DIENTES (Odontograma + Historia) ---
    const filtroInput = document.getElementById('filtroDiente');
    if (filtroInput) {
        filtroInput.addEventListener('input', function () {
            const value = this.value.trim().toLowerCase();

            // Filtrar SVG
            const dientes = document.querySelectorAll('.odontograma-svg .diente');
            if(dientes.length){
                dientes.forEach(d => {
                    if (!value || d.dataset.diente.toLowerCase().includes(value)) {
                        d.style.opacity = 1;
                        d.classList.add('resaltado'); // opcional: resaltar
                    } else {
                        d.style.opacity = 0.2;
                        d.classList.remove('resaltado');
                    }
                });
            }

            // Filtrar tabla de historia odontológica
            const filasHistoria = document.querySelectorAll('.fila-historia');
            if(filasHistoria.length){
                filasHistoria.forEach(fila => {
                    const dienteFila = fila.dataset.diente.toLowerCase();
                    if (!value || dienteFila.includes(value)) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                });
            }
        });
    }

    // --- CALCULAR TOTAL ---
    function calcularTotal() {
        let total = 0;

        const precios = document.querySelectorAll('.precio');
        if(precios.length){
            precios.forEach(input => {
                let valor = parseFloat(input.value) || 0;
                total += valor;
            });
        }

        const totalPlan = document.getElementById('totalPlan');
        if(totalPlan){
            totalPlan.innerText = '$' + total.toFixed(2);
        }
    }

    const preciosInputs = document.querySelectorAll('.precio');
    if(preciosInputs.length){
        preciosInputs.forEach(input => {
            input.addEventListener('input', calcularTotal);
        });
    }

    // --- VALIDACIÓN PLAN ---
    const formPlan = document.getElementById('formPlan');
    if(formPlan){
        formPlan.addEventListener('submit', function(e){
            let valido = true;

            document.querySelectorAll('.tratamiento').forEach(sel => {
                if(sel.value == '') valido = false;
            });

            document.querySelectorAll('.precio').forEach(inp => {
                if(inp.value == '') valido = false;
            });

            if(!valido){
                e.preventDefault();
                alert('Todos los dientes deben tener tratamiento y precio asignado');
            }
        });
    }

    // --- FILTRO HISTORIA DIENTES ---
    if (filtroInput) {
        filtroInput.addEventListener('keyup', function(){
            let txt = this.value.toLowerCase();

            const filasHistoria = document.querySelectorAll('.fila-historia');
            if(filasHistoria.length){
                filasHistoria.forEach(fila => {
                    let d = fila.dataset.diente.toLowerCase();
                    let e = fila.dataset.estado.toLowerCase();
                    let o = (fila.dataset.obs || '').toLowerCase();

                    if(d.includes(txt) || e.includes(txt) || o.includes(txt)){
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                });
            }
        });
    }

});
