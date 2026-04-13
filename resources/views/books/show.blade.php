@extends('layouts.master')

@section('title', $buku->judul)
@section('page-title', 'Detail Buku')
@section('page-subtitle', $buku->judul)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-amber-50/20 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Detail Buku</h1>
                    <p class="text-slate-500 text-sm mt-1">Informasi lengkap buku: <span class="font-semibold text-amber-600">{{ $buku->judul }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Book Info Card --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Main Book Card --}}
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-5">
                        <h2 class="text-white font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Informasi Buku
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="w-36 h-48 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-4 overflow-hidden shadow-lg">
                                @if($buku->cover && file_exists(public_path('covers/'.$buku->cover)))
                                    <img src="{{ asset('covers/'.$buku->cover) }}" alt="cover" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-book text-amber-400 text-5xl"></i>
                                @endif
                            </div>
                            <h2 class="font-bold text-slate-800 text-xl leading-tight">{{ $buku->judul }}</h2>
                            <p class="text-slate-500 text-sm mt-2">
                                <i class="fas fa-user-edit mr-1"></i>{{ $buku->pengarang }}
                            </p>
                            <div class="mt-4">
                                @if($buku->stok_tersedia > 0)
                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-circle text-xs"></i>
                                        Tersedia ({{ $buku->stok_tersedia }} eksemplar)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                        <i class="fas fa-circle text-xs"></i>
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4 text-sm">
                            @foreach([
                                ['icon' => 'fa-barcode', 'label' => 'Kode Buku', 'value' => $buku->kode_buku, 'mono' => true],
                                ['icon' => 'fa-building', 'label' => 'Penerbit', 'value' => $buku->penerbit],
                                ['icon' => 'fa-calendar', 'label' => 'Tahun Terbit', 'value' => $buku->tahun_terbit],
                                ['icon' => 'fa-tag', 'label' => 'Kategori', 'value' => $buku->kategori],
                                ['icon' => 'fa-qrcode', 'label' => 'ISBN', 'value' => $buku->isbn ?? '-'],
                                ['icon' => 'fa-boxes', 'label' => 'Stok Total', 'value' => $buku->stok . ' eksemplar'],
                                ['icon' => 'fa-check-circle', 'label' => 'Stok Tersedia', 'value' => $buku->stok_tersedia . ' eksemplar', 'highlight' => true],
                            ] as $info)
                            <div class="flex justify-between items-center gap-3 p-2 hover:bg-slate-50 rounded-lg transition-colors">
                                <span class="text-slate-500 flex items-center gap-2">
                                    <i class="fas {{ $info['icon'] }} text-amber-500 w-4"></i>
                                    {{ $info['label'] }}
                                </span>
                                @if(isset($info['mono']) && $info['mono'])
                                    <span class="font-mono bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-xs font-semibold">{{ $info['value'] }}</span>
                                @elseif(isset($info['highlight']))
                                    <span class="font-bold text-emerald-600 text-right">{{ $info['value'] }}</span>
                                @else
                                    <span class="font-medium text-slate-700 text-right">{{ $info['value'] }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @if($buku->deskripsi)
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-align-left text-amber-500 text-sm"></i>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Deskripsi</p>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $buku->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats Card --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Statistik Peminjaman</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 text-sm">Total Peminjaman</span>
                            <span class="font-bold text-2xl text-blue-600">{{ $buku->peminjaman->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 text-sm">Sedang Dipinjam</span>
                            <span class="font-bold text-lg text-orange-600">{{ $buku->peminjaman->where('status', 'dipinjam')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 text-sm">Selesai</span>
                            <span class="font-bold text-lg text-emerald-600">{{ $buku->peminjaman->where('status', 'selesai')->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                    <a href="{{ route('buku.edit', $buku) }}" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-pen"></i>
                        Edit Buku
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('buku.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            {{-- Riwayat Peminjaman --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-5">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                                    <i class="fas fa-history"></i>
                                    Riwayat Peminjaman
                                </h3>
                                <p class="text-slate-400 text-sm mt-1">
                                    {{ $buku->peminjaman->count() }} total peminjaman
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Selesai: {{ $buku->peminjaman->where('status', 'selesai')->count() }}
                                </span>
                                <span class="px-3 py-1 bg-orange-500/20 text-orange-300 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-book mr-1"></i>Dipinjam: {{ $buku->peminjaman->where('status', 'dipinjam')->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/80">
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i> Anggota
                                    </th>
                                    <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <i class="fas fa-calendar-alt mr-1"></i> Tgl Pinjam
                                    </th>
                                    <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <i class="fas fa-calendar-check mr-1"></i> Tgl Kembali
                                    </th>
                                    <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <i class="fas fa-flag-checkered mr-1"></i> Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($buku->peminjaman->sortByDesc('created_at') as $p)
                                <tr class="hover:bg-amber-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $p->anggota->nama ?? '-' }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $p->anggota->no_anggota ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-slate-700">
                                            <span class="font-medium">{{ $p->tanggal_pinjam->format('d M Y') }}</span>
                                            <p class="text-xs text-slate-400">{{ $p->tanggal_pinjam->format('H:i') }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-slate-700">
                                            <span class="font-medium">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</span>
                                            @if($p->tanggal_kembali_actual)
                                                <p class="text-xs text-emerald-600">(Kembali {{ $p->tanggal_kembali_actual->format('d M Y') }})</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        @php
                                            $statusConfig = [
                                                'dipinjam' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-book', 'label' => 'Dipinjam'],
                                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'label' => 'Selesai'],
                                                'terlambat' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-exclamation-triangle', 'label' => 'Terlambat'],
                                                'booking' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock', 'label' => 'Booking'],
                                            ];
                                            $config = $statusConfig[$p->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-circle', 'label' => ucfirst($p->status)];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                            <i class="fas {{ $config['icon'] }} text-xs"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-slate-400 text-3xl"></i>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada riwayat peminjaman</p>
                                            <p class="text-slate-400 text-sm mt-1">Buku ini belum pernah dipinjam</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($buku->peminjaman->count() > 5)
                    <div class="border-t border-slate-100 px-6 py-4 bg-slate-50/50">
                        <a href="#" class="text-amber-600 hover:text-amber-700 text-sm font-semibold flex items-center justify-center gap-1">
                            Lihat Semua Riwayat
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection