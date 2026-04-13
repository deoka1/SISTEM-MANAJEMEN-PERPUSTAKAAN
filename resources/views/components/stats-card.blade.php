@props(['title', 'value', 'icon', 'color' => 'primary', 'subtitle' => null])

@php
$colors = [
    'primary' => ['bg' => 'bg-primary-500', 'light' => 'bg-primary-50', 'text' => 'text-primary-600'],
    'emerald' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
    'amber'   => ['bg' => 'bg-amber-500',   'light' => 'bg-amber-50',   'text' => 'text-amber-600'],
    'red'     => ['bg' => 'bg-red-500',     'light' => 'bg-red-50',     'text' => 'text-red-600'],
    'violet'  => ['bg' => 'bg-violet-500',  'light' => 'bg-violet-50',  'text' => 'text-violet-600'],
];
$c = $colors[$color] ?? $colors['primary'];
@endphp

<div class="card p-6 flex items-center gap-5">
    <div class="w-14 h-14 {{ $c['light'] }} {{ $c['text'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
        <i class="fas {{ $icon }} text-2xl"></i>
    </div>
    <div>
        <p class="text-slate-400 text-sm font-medium">{{ $title }}</p>
        <p class="text-3xl font-bold text-slate-800 leading-tight mt-0.5">{{ $value }}</p>
        @if($subtitle)
            <p class="text-slate-400 text-xs mt-1">{{ $subtitle }}</p>
        @endif
    </div>
</div>
