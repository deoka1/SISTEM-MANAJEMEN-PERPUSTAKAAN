@extends('layouts.master')

@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking')
@section('page-subtitle', 'Konfirmasi permintaan booking dari pelanggan')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-yellow-500 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs">Total Booking</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalBooking ?? $booking->total() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-bookmark text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-amber-500 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs">Menunggu</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $totalMenunggu ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-emerald-500 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs">Disetujui</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $totalDisetujui ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs">Selesai</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalSelesai ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-flag-checkered text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-red-500 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $totalDitolak ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Banner --}}
    @if(($totalMenunggu ?? 0) > 0)
    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-xl px-5 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center animate-pulse">
                <i class="fas fa-bell text-amber-500 text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-amber-800">Ada <strong class="text-lg">{{ $totalMenunggu }}</strong> booking menunggu konfirmasi!</p>
                <p class="text-amber-600 text-sm">Segera proses agar pelanggan mendapat kepastian.</p>
            </div>
        </div>
        <a href="{{ route('booking.index', ['status' => 'menunggu']) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md">
            <i class="fas fa-eye"></i> Lihat Semua
        </a>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="card overflow-hidden">
        {{-- Header with Filter --}}
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <form method="GET" action="{{ route('booking.index') }}" class="flex-1 flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari kode booking, nama, no. anggota..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="status" class="pl-11 pr-8 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                    
                    {{-- Date Filter --}}
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="date" 
                               name="tanggal" 
                               value="{{ request('tanggal') }}" 
                               class="pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    {{-- Action Buttons --}}
                    <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    
                    @if(request()->hasAny(['search','status','tanggal']))
                        <a href="{{ route('booking.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-qrcode mr-1"></i> Kode Booking
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-user mr-1"></i> Peminjam
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-book mr-1"></i> Buku
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-check mr-1"></i> Tgl Ambil
                        </th>
                        <th class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-return mr-1"></i> Tgl Kembali
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
                    @forelse($booking as $b)
                    <tr class="hover:bg-yellow-50/30 transition-colors group {{ $b->status === 'menunggu' ? 'bg-amber-50/20' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-qrcode text-slate-400 text-xs"></i>
                                <span class="font-mono text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-lg">{{ $b->kode_booking }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($b->nama_peminjam, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 group-hover:text-yellow-600 transition">{{ $b->nama_peminjam }}</p>
                                    <p class="text-slate-400 text-xs">{{ $b->no_anggota }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <p class="font-medium text-slate-700 text-sm">{{ Str::limit($b->buku->judul ?? '-', 35) }}</p>
                            @if($b->buku)
                                <p class="text-slate-400 text-xs">{{ $b->buku->pengarang }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 text-slate-600 text-xs">
                                <i class="fas fa-calendar-alt text-slate-400 text-[10px]"></i>
                                {{ $b->tanggal_pinjam_rencana->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 text-slate-600 text-xs">
                                <i class="fas fa-calendar-alt text-slate-400 text-[10px]"></i>
                                {{ $b->tanggal_kembali_rencana->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $statusMap = [
                                'menunggu'  => ['bg-amber-100', 'text-amber-700', '⏳ Menunggu'],
                                'disetujui' => ['bg-emerald-100', 'text-emerald-700', '✅ Disetujui'],
                                'ditolak'   => ['bg-red-100', 'text-red-700', '❌ Ditolak'],
                                'selesai'   => ['bg-blue-100', 'text-blue-700', '🏁 Selesai'],
                            ];
                            $status = $statusMap[$b->status] ?? ['bg-slate-100', 'text-slate-600', $b->status];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $status[0] }} {{ $status[1] }}">
                                {{ $status[2] }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('booking.show', $b) }}" 
                                   class="w-8 h-8 bg-slate-100 hover:bg-yellow-100 text-slate-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition-all" 
                                   title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                
                                @if($b->status === 'menunggu')
                                <form method="POST" action="{{ route('booking.setujui', $b) }}" class="inline" onsubmit="return confirm('Setujui booking ini?')">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-all" title="Setujui">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                </form>
                                
                                <button onclick="openTolakModal({{ $b->id }}, '{{ $b->kode_booking }}', '{{ $b->nama_peminjam }}')" 
                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" 
                                        title="Tolak">
                                    <i class="fas fa-xmark text-xs"></i>
                                </button>
                                @endif
                                
                                @if($b->status === 'disetujui')
                                <form method="POST" action="{{ route('booking.selesai', $b) }}" class="inline" onsubmit="return confirm('Tandai selesai dan buat data peminjaman?')">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-all" title="Selesai">
                                        <i class="fas fa-flag-checkered text-xs"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form method="POST" action="{{ route('booking.destroy', $b) }}" class="inline" onsubmit="return confirm('Hapus data booking {{ $b->kode_booking }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" title="Hapus">
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
                                    <i class="fas fa-bookmark text-slate-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-600">Belum ada data booking</h3>
                                <p class="text-slate-400 text-sm mt-1">Booking akan muncul ketika pelanggan melakukan pemesanan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($booking->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm text-slate-500 flex items-center gap-1">
                <i class="fas fa-chart-simple text-yellow-500"></i>
                Menampilkan <span class="font-semibold text-slate-700">{{ $booking->firstItem() }}</span> - 
                <span class="font-semibold text-slate-700">{{ $booking->lastItem() }}</span> dari 
                <span class="font-semibold text-slate-700">{{ $booking->total() }}</span> booking
            </p>
            <div>
                {{ $booking->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tolak --}}
<div id="tolak-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-ban text-red-500"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tolak Booking</h3>
                    <p id="modal-booking-info" class="text-slate-400 text-sm">Kode: - | Peminjam: -</p>
                </div>
            </div>
        </div>
        
        <form id="tolak-form" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="form-label flex items-center gap-2">
                    <i class="fas fa-comment-dots text-red-500 text-xs"></i>
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="alasan_penolakan" 
                          rows="4" 
                          class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition" 
                          placeholder="Contoh: Stok buku habis, data anggota tidak valid, buku sedang diperbaiki..." 
                          required></textarea>
                <p class="text-xs text-slate-400 mt-1">Alasan akan dikirim ke pelanggan via notifikasi</p>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-xmark"></i> Tolak Booking
                </button>
                <button type="button" onclick="closeTolakModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openTolakModal(id, kode, nama) {
    document.getElementById('tolak-form').action = `/booking/${id}/tolak`;
    document.getElementById('modal-booking-info').innerHTML = `Kode: ${kode} | Peminjam: ${nama}`;
    document.getElementById('tolak-modal').classList.remove('hidden');
}

function closeTolakModal() {
    document.getElementById('tolak-modal').classList.add('hidden');
    document.getElementById('tolak-form').reset();
}

// Close modal when clicking outside
document.getElementById('tolak-modal').addEventListener('click', function(e) {
    if (e.target === this) closeTolakModal();
});

// Auto refresh alert setelah 5 detik (opsional)
setTimeout(() => {
    const alert = document.querySelector('.animate-pulse');
    if (alert) {
        alert.style.animation = 'none';
    }
}, 5000);
</script>
@endpush

@push('styles')
<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
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
</style>
@endpush
@endsection