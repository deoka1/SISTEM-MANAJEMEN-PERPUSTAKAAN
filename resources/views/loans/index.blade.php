@extends('layouts.master')

@section('title', 'Peminjaman')
@section('page-title', 'Peminjaman Buku')
@section('page-subtitle', 'Kelola transaksi peminjaman dan pengembalian buku')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-yellow-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalPeminjaman ?? $peminjaman->total() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-book-open text-yellow-600"></i>
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
                    <i class="fas fa-book text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-emerald-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Dikembalikan</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $dikembalikan ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-red-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Terlambat</p>
                    <p class="text-2xl font-bold text-red-600">{{ $terlambat ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-clock text-red-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-purple-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm">Total Denda</p>
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-money-bill text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Banner for Late Returns --}}
    @if(($terlambat ?? 0) > 0)
    <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-xl px-5 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center animate-pulse">
                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-red-800">Ada <strong class="text-lg">{{ $terlambat }}</strong> peminjaman terlambat!</p>
                <p class="text-red-600 text-sm">Segera konfirmasi pengembalian untuk menghindari akumulasi denda.</p>
            </div>
        </div>
        <a href="{{ route('peminjaman.index', ['status' => 'terlambat']) }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md">
            <i class="fas fa-eye"></i> Lihat Semua
        </a>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="card overflow-hidden">
        {{-- Header with Filter --}}
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <form method="GET" action="{{ route('peminjaman.index') }}" class="flex-1 flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari kode pinjam, nama anggota, judul buku..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="relative min-w-[160px]">
                        <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="status" class="pl-11 pr-8 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>📖 Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>✅ Dikembalikan</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>⚠️ Terlambat</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                    
                    {{-- Date Range Filter --}}
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="date" 
                               name="tanggal_dari" 
                               value="{{ request('tanggal_dari') }}" 
                               placeholder="Dari"
                               class="pl-11 pr-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 w-40">
                    </div>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="date" 
                               name="tanggal_sampai" 
                               value="{{ request('tanggal_sampai') }}" 
                               placeholder="Sampai"
                               class="pl-11 pr-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 w-40">
                    </div>
                    
                    {{-- Action Buttons --}}
                    <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    
                    @if(request()->hasAny(['search','status','tanggal_dari','tanggal_sampai']))
                        <a href="{{ route('peminjaman.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('peminjaman.create') }}" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Catat Peminjaman
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-qrcode mr-1"></i> Kode Pinjam
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-user mr-1"></i> Anggota
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-book mr-1"></i> Buku
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-check mr-1"></i> Tgl Pinjam
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-times mr-1"></i> Tgl Kembali
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
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-yellow-50/30 transition-colors group {{ $p->isTerlambat() ? 'bg-red-50/20' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-qrcode text-slate-400 text-xs"></i>
                                <span class="font-mono text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-lg">{{ $p->kode_pinjam }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($p->anggota->nama ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 group-hover:text-yellow-600 transition">{{ $p->anggota->nama ?? '-' }}</p>
                                    <p class="text-slate-400 text-xs">{{ $p->anggota->no_anggota ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <p class="font-medium text-slate-700">{{ Str::limit($p->buku->judul ?? '-', 35) }}</p>
                            <p class="text-slate-400 text-xs">{{ $p->buku->kode_buku ?? '' }}</p>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 text-slate-600 text-xs">
                                <i class="fas fa-calendar-alt text-slate-400 text-[10px]"></i>
                                {{ $p->tanggal_pinjam->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-1 text-xs {{ $p->isTerlambat() ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                                    <i class="fas fa-calendar-alt text-slate-400 text-[10px]"></i>
                                    {{ $p->tanggal_kembali_rencana->format('d M Y') }}
                                </div>
                                @if($p->isTerlambat())
                                    <span class="inline-flex items-center gap-1 text-red-500 text-xs mt-1">
                                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                                        {{ now()->diffInDays($p->tanggal_kembali_rencana) }} hari terlambat
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $statusMap = [
                                    'dipinjam' => ['bg-blue-100', 'text-blue-700', '📖 Dipinjam'],
                                    'dikembalikan' => ['bg-emerald-100', 'text-emerald-700', '✅ Dikembalikan'],
                                    'terlambat' => ['bg-red-100', 'text-red-700', '⚠️ Terlambat'],
                                ];
                                $status = $statusMap[$p->status] ?? ['bg-slate-100', 'text-slate-600', $p->status];
                                if ($p->isTerlambat()) {
                                    $status = $statusMap['terlambat'];
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $status[0] }} {{ $status[1] }}">
                                {{ $status[2] }}
                            </span>
                            @if($p->denda > 0 && $p->status == 'dikembalikan')
                                <span class="block text-xs text-purple-600 mt-1">Denda: Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('peminjaman.show', $p) }}" 
                                   class="w-8 h-8 bg-slate-100 hover:bg-yellow-100 text-slate-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                @if($p->status !== 'dikembalikan')
                                    <button onclick="openKembalikanModal({{ $p->id }}, '{{ $p->kode_pinjam }}', '{{ $p->anggota->nama ?? '' }}')" 
                                            class="w-8 h-8 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-all" 
                                            title="Kembalikan">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                    <a href="{{ route('peminjaman.edit', $p) }}" 
                                       class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-all" 
                                       title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('peminjaman.destroy', $p) }}" onsubmit="return confirm('Yakin ingin menghapus data peminjaman {{ $p->kode_pinjam }}?')" class="inline">
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
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-book-open text-slate-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-600">Belum ada data peminjaman</h3>
                                <p class="text-slate-400 text-sm mt-1">Mulai dengan mencatat peminjaman baru</p>
                                <a href="{{ route('peminjaman.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-plus"></i> Catat Peminjaman Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($peminjaman->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm text-slate-500 flex items-center gap-1">
                <i class="fas fa-chart-simple text-yellow-500"></i>
                Menampilkan <span class="font-semibold text-slate-700">{{ $peminjaman->firstItem() }}</span> - 
                <span class="font-semibold text-slate-700">{{ $peminjaman->lastItem() }}</span> dari 
                <span class="font-semibold text-slate-700">{{ $peminjaman->total() }}</span> data
            </p>
            <div>
                {{ $peminjaman->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Kembalikan --}}
<div id="kembalikan-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-undo-alt text-emerald-500"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Konfirmasi Pengembalian</h3>
                        <p id="modal-booking-info" class="text-slate-400 text-sm">Kode: - | Anggota: -</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="kembalikan-form" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="form-label flex items-center gap-2">
                        <i class="fas fa-calendar-check text-emerald-500 text-xs"></i>
                        Tanggal Pengembalian Aktual <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_kembali_aktual" 
                           value="{{ date('Y-m-d') }}" 
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition" 
                           required>
                </div>
                <div>
                    <label class="form-label flex items-center gap-2">
                        <i class="fas fa-sticky-note text-emerald-500 text-xs"></i>
                        Keterangan
                    </label>
                    <textarea name="keterangan" 
                              rows="3" 
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition" 
                              placeholder="Catatan pengembalian (opsional)"></textarea>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                        <div class="text-sm">
                            <p class="font-semibold text-amber-800">Informasi Denda</p>
                            <p class="text-amber-700 text-xs mt-1">
                                Denda keterlambatan: <strong>Rp 1.000/hari</strong><br>
                                Denda akan dihitung otomatis berdasarkan tanggal pengembalian.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-check"></i> Konfirmasi Kembali
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openKembalikanModal(id, kode, nama) {
    const form = document.getElementById('kembalikan-form');
    form.action = `/peminjaman/${id}/kembalikan`;
    document.getElementById('modal-booking-info').innerHTML = `Kode: ${kode} | Anggota: ${nama}`;
    document.getElementById('kembalikan-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('kembalikan-modal').classList.add('hidden');
    document.getElementById('kembalikan-form').reset();
}

// Close modal when clicking outside
document.getElementById('kembalikan-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush

@push('styles')
<style>
    /* Custom Pagination */
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
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush
@endsection