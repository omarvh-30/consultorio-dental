@php
$colores = [
    'sano' => 'success',
    'caries' => 'danger',
    'obturado' => 'primary',
    'endodoncia' => 'warning',
    'extraido' => 'dark',
];
@endphp

<span class="badge bg-{{ $colores[$estado] ?? 'secondary' }} text-capitalize">
    {{ $estado }}
</span>
