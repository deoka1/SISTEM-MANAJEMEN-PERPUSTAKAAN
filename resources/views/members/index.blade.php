@extends('layouts.master')

@section('title', 'Manajemen Anggota')
@section('page-title', 'Manajemen Anggota')
@section('page-subtitle', 'Kelola data anggota perpustakaan')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Total Anggota</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalAnggota ?? $anggota->total() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-users text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Anggota Aktif</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $anggotaAktif ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-user-check text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Anggota Nonaktif</p>
                    <p class="text-2xl font-bold text-red-600">{{ $anggotaNonaktif ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-user-slash text-red-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Akan Expired</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $akanExpired ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card overflow-hidden">
        {{-- Header with Filter --}}
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <form method="GET" action="{{ route('anggota.index') }}" class="flex-1 flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama, no. anggota, email..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="status" class="pl-11 pr-8 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    
                    @if(request()->hasAny(['search','status']))
                        <a href="{{ route('anggota.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('anggota.create') }}" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-user-plus"></i> Tambah Anggota
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-user mr-1"></i> Anggota
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-id-card mr-1"></i> No. Anggota
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-phone mr-1"></i> Kontak
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-1"></i> Masa Berlaku
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-circle mr-1"></i> Status
                        </th>
                        <th class="text-center px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-cog mr-1"></i> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($anggota as $a)
                    <tr class="hover:bg-yellow-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                    {{ $a->jenis_kelamin === 'L' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-pink-500 to-pink-600' }}">
                                    {{ strtoupper(substr($a->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 group-hover:text-yellow-600 transition">{{ $a->nama }}</p>
                                    <p class="text-slate-400 text-xs flex items-center gap-1">
                                        <i class="fas {{ $a->jenis_kelamin === 'L' ? 'fa-mars' : 'fa-venus' }} text-[10px]"></i>
                                        {{ $a->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-lg">
                                {{ $a->no_anggota }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-slate-700 flex items-center gap-1">
                                <i class="fas fa-envelope text-slate-400 text-[10px]"></i>
                                {{ Str::limit($a->email, 25) }}
                            </p>
                            @if($a->telepon)
                                <p class="text-slate-400 text-xs flex items-center gap-1 mt-0.5">
                                    <i class="fas fa-phone text-slate-400 text-[10px]"></i>
                                    {{ $a->telepon }}
                                </p>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-xs">
                                <p class="text-slate-600 flex items-center gap-1">
                                    <i class="fas fa-calendar-plus text-slate-400 text-[10px]"></i>
                                    {{ $a->tanggal_daftar->format('d M Y') }}
                                </p>
                                <p class="mt-1 flex items-center gap-1 {{ $a->tanggal_expired < now() ? 'text-red-500 font-medium' : 'text-slate-400' }}">
                                    <i class="fas fa-calendar-times text-[10px]"></i>
                                    Exp: {{ $a->tanggal_expired->format('d M Y') }}
                                </p>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <x-badge :status="$a->status" />
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('anggota.show', $a) }}" 
                                   class="w-8 h-8 bg-slate-100 hover:bg-yellow-100 text-slate-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('anggota.edit', $a) }}" 
                                   class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('anggota.destroy', $a) }}" onsubmit="return confirm('Yakin ingin menghapus anggota {{ $a->nama }}?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" 
                                            title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-user-slash text-slate-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-600">Belum ada data anggota</h3>
                                <p class="text-slate-400 text-sm mt-1">Mulai dengan menambahkan anggota baru</p>
                                <a href="{{ route('anggota.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-user-plus"></i> Tambah Anggota Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($anggota->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm text-slate-500 flex items-center gap-1">
                <i class="fas fa-chart-simple text-yellow-500"></i>
                Menampilkan <span class="font-semibold text-slate-700">{{ $anggota->firstItem() }}</span> - 
                <span class="font-semibold text-slate-700">{{ $anggota->lastItem() }}</span> dari 
                <span class="font-semibold text-slate-700">{{ $anggota->total() }}</span> anggota
            </p>
            <div>
                {{ $anggota->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Pagination Style */
    nav[role="navigation"] .relative {
        @apply inline-flex items-center gap-1;
    }
    nav[role="navigation"] .relative a,
    nav[role="navigation"] .relative span {
        @apply px-3 py-1.5 rounded-lg text-sm font-medium transition-all;
    }
    nav[role="navigation"] .relative a {
        @apply text-slate-600 hover:bg-yellow-500 hover:text-white;
    }
    nav[role="navigation"] .relative span[aria-current="page"] {
        @apply bg-gradient-to-r from-yellow-500 to-amber-500 text-white shadow-sm;
    }
    nav[role="navigation"] .relative .dots {
        @apply text-slate-400;
    }
</style>
@endpush