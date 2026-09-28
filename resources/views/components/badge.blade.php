@props(['stock' => 0])

@php
    if ($stock <= 0) {
        $status = 'Habis';
        $classes = 'bg-red-100 text-red-800 border-red-200';
    } elseif ($stock < 10) {
        $status = 'Menipis';
        $classes = 'bg-yellow-100 text-yellow-800 border-yellow-200';
    } else {
        $status = 'Aman';
        $classes = 'bg-green-100 text-green-800 border-green-200';
    }
@endphp

<span {{ $attributes->merge(['class' => 'px-2.5 py-0.5 rounded-full text-xs font-medium border ' . $classes]) }}>
    {{ $status }}
</span>