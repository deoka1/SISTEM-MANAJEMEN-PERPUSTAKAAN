@extends('layouts.master')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')
@section('page-subtitle', 'Kelola koleksi buku perpustakaan')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-yellow-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Total Buku</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalBuku ?? $buku->total() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-book text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-emerald-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Buku Tersedia</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $bukuTersedia ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $sedangDipinjam ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-book-open text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-amber-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Kategori</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $totalKategori ?? $kategori->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-tags text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card overflow-hidden">
        {{-- Header with Filter --}}
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <form method="GET" action="{{ route('buku.index') }}" class="flex-1 flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari judul, pengarang, atau ISBN..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    
                    {{-- Kategori Filter --}}
                    <div class="relative min-w-[180px]">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="kategori" class="pl-11 pr-8 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    
                    @if(request()->hasAny(['search','kategori']))
                        <a href="{{ route('buku.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('buku.create') }}" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Tambah Buku
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-book mr-1"></i> Buku
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-barcode mr-1"></i> Kode
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-tag mr-1"></i> Kategori
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-boxes mr-1"></i> Stok
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-chart-line mr-1"></i> Status
                        </th>
                        <th class="text-center px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-cog mr-1"></i> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($buku as $b)
                    <tr class="hover:bg-yellow-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-14 rounded-lg bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($b->cover && file_exists(public_path('covers/'.$b->cover)))
                                        <img src="{{ asset('covers/'.$b->cover) }}" alt="cover" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-book text-slate-400 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 group-hover:text-yellow-600 transition">{{ Str::limit($b->judul, 40) }}</p>
                                    <p class="text-slate-400 text-xs flex items-center gap-2 mt-0.5">
                                        <i class="fas fa-user-pen text-[10px]"></i>
                                        {{ $b->pengarang }}
                                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                        <i class="fas fa-calendar-alt text-[10px]"></i>
                                        {{ $b->tahun_terbit }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-lg">{{ $b->kode_buku }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-700">
                                <i class="fas fa-tag text-[10px]"></i>
                                {{ $b->kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800">{{ $b->stok_tersedia }}</span>
                                    <span class="text-slate-400">/ {{ $b->stok }}</span>
                                    <span class="text-xs text-slate-400">tersedia</span>
                                </div>
                                @php
                                    $persentase = $b->stok > 0 ? ($b->stok_tersedia / $b->stok) * 100 : 0;
                                @endphp
                                <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-yellow-500 to-amber-500 rounded-full" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @if($b->stok_tersedia > 0)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle text-[10px]"></i>
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('buku.show', $b) }}" 
                                   class="w-8 h-8 bg-slate-100 hover:bg-yellow-100 text-slate-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('buku.edit', $b) }}" 
                                   class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('buku.destroy', $b) }}" onsubmit="return confirm('Yakin ingin menghapus buku {{ $b->judul }}?')" class="inline">
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
                                    <i class="fas fa-book text-slate-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-600">Belum ada data buku</h3>
                                <p class="text-slate-400 text-sm mt-1">Mulai dengan menambahkan buku baru</p>
                                <a href="{{ route('buku.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-plus"></i> Tambah Buku Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($buku->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm text-slate-500 flex items-center gap-1">
                <i class="fas fa-chart-simple text-yellow-500"></i>
                Menampilkan <span class="font-semibold text-slate-700">{{ $buku->firstItem() }}</span> - 
                <span class="font-semibold text-slate-700">{{ $buku->lastItem() }}</span> dari 
                <span class="font-semibold text-slate-700">{{ $buku->total() }}</span> buku
            </p>
            <div>
                {{ $buku->links() }}
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