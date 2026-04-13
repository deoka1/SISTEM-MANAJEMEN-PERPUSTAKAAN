@props(['type' => 'success', 'message'])

@php
$config = [
    'success' => [
        'bg'   => 'bg-emerald-50 border-emerald-200',
        'text' => 'text-emerald-800',
        'icon' => 'fa-circle-check text-emerald-500',
    ],
    'error' => [
        'bg'   => 'bg-red-50 border-red-200',
        'text' => 'text-red-800',
        'icon' => 'fa-circle-xmark text-red-500',
    ],
    'warning' => [
        'bg'   => 'bg-amber-50 border-amber-200',
        'text' => 'text-amber-800',
        'icon' => 'fa-triangle-exclamation text-amber-500',
    ],
    'info' => [
        'bg'   => 'bg-blue-50 border-blue-200',
        'text' => 'text-blue-800',
        'icon' => 'fa-circle-info text-blue-500',
    ],
];
$c = $config[$type] ?? $config['success'];
@endphp

<div data-alert class="flex items-center gap-3 px-4 py-3 rounded-xl border {{ $c['bg'] }} {{ $c['text'] }} mb-4 text-sm font-medium">
    <i class="fas {{ $c['icon'] }} text-base flex-shrink-0"></i>
    <span>{{ $message }}</span>
    <button onclick="this.parentElement.remove()" class="ml-auto opacity-60 hover:opacity-100">
        <i class="fas fa-xmark"></i>
    </button>
</div>
