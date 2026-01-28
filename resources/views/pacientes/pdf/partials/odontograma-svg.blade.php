<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { margin: 0; background: transparent; }

.diente path {
    fill: #ffffff;
    stroke: {{ $paciente->es_ortodoncia ? '#0d6efd' : '#222' }};
    stroke-width: {{ $paciente->es_ortodoncia ? '1.6' : '1' }};
}

.sano path { fill: #ffffff; }
.caries path { fill: #ff6b6b; }
.obturado path { fill: #4dabf7; }
.endodoncia path { fill: #f59f00; }
.extraido path { fill: #adb5bd; }

.ausente path {
    fill: none;
    stroke-dasharray: 5;
    opacity: 0.4;
}
</style>
</head>
<body>

{{-- ✅ PROTECCIÓN TOTAL --}}
@include('odontograma.svg', [
    'paciente' => $paciente ?? null
])

<script>
const estados = @json($odontograma ?? []);

Object.keys(estados).forEach(diente => {
    const el = document.getElementById('diente-' + diente);
    if (el && estados[diente].estado) {
        el.classList.add(estados[diente].estado);
    }
});
</script>

</body>
</html>
