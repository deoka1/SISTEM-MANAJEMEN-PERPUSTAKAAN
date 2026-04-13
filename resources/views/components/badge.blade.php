@props(['status'])

@php
$map = [
    'aktif'        => 'bg-emerald-100 text-emerald-700',
    'nonaktif'     => 'bg-slate-100 text-slate-600',
    'dipinjam'     => 'bg-blue-100 text-blue-700',
    'dikembalikan' => 'bg-emerald-100 text-emerald-700',
    'terlambat'    => 'bg-red-100 text-red-700',
    'tersedia'     => 'bg-emerald-100 text-emerald-700',
    'habis'        => 'bg-red-100 text-red-700',
    'admin'        => 'bg-violet-100 text-violet-700',
    'petugas'      => 'bg-sky-100 text-sky-700',
];
$class = $map[$status] ?? 'bg-slate-100 text-slate-600';

$labels = [
    'aktif'        => 'Aktif',
    'nonaktif'     => 'Nonaktif',
    'dipinjam'     => 'Dipinjam',
    'dikembalikan' => 'Dikembalikan',
    'terlambat'    => 'Terlambat',
    'tersedia'     => 'Tersedia',
    'habis'        => 'Habis',
    'admin'        => 'Admin',
    'petugas'      => 'Petugas',
];
$label = $labels[$status] ?? ucfirst($status);
@endphp

<span class="badge {{ $class }}">{{ $label }}</span>
