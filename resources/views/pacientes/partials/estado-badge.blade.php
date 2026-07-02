@php
$colores = [
    'sano' => 'success',
    'caries' => 'danger',
    'obturado' => 'primary',
    'endodoncia' => 'warning',
    'extraccion' => 'orange', 
    'extraido' => 'dark',
];
@endphp

<span class="badge bg-{{ $colores[$estado] ?? 'secondary' }} text-capitalize">
    {{ $estado }}
</span>
