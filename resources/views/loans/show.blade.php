@extends('layouts.master')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', 'Kode: ' . $peminjaman->kode_pinjam)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
        {{-- Gradient Border Top --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 via-amber-500 to-yellow-500"></div>
        
        <div class="p-6 lg:p-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-xl">Detail Peminjaman</h3>
                        <p class="text-slate-400 text-sm">Informasi lengkap transaksi peminjaman</p>
                    </div>
                </div>
                <div class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs font-mono">
                    <i class="fas fa-qrcode mr-1"></i> {{ $peminjaman->kode_pinjam }}
                </div>
            </div>

            {{-- Status Banner --}}
            @if($peminjaman->isTerlambat())
            <div class="mb-6 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-red-800 text-lg">Buku Terlambat Dikembalikan!</p>
                        <p class="text-red-600 mt-1">
                            Terlambat <strong class="text-xl">{{ now()->diffInDays($peminjaman->tanggal_kembali_rencana) }}</strong> hari
                        </p>
                        <div class="mt-3 bg-white/50 rounded-lg p-3">
                            <p class="text-red-700 text-sm flex items-center gap-2">
                                <i class="fas fa-money-bill-wave"></i>
                                Denda estimasi: 
                                <strong class="text-lg">Rp {{ number_format(now()->diffInDays($peminjaman->tanggal_kembali_rencana) * 1000, 0, ',', '.') }}</strong>
                                <span class="text-xs text-red-500">(Rp 1.000/hari)</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($peminjaman->status === 'dikembalikan')
            <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-emerald-800">Buku Telah Dikembalikan</p>
                        <p class="text-emerald-600 text-sm mt-1">
                            Dikembalikan pada {{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}
                            @if($peminjaman->denda > 0)
                                dengan denda <strong>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</strong>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                {{-- Informasi Peminjaman --}}
                <div class="bg-slate-50 rounded-xl p-5">
                    <h4 class="font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-yellow-500"></i>
                        Informasi Peminjaman
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Kode Pinjam</span>
                            <span class="font-mono text-sm bg-white px-2 py-0.5 rounded text-slate-700">{{ $peminjaman->kode_pinjam }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Tanggal Pinjam</span>
                            <span class="font-semibold text-slate-700">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Tgl Kembali Rencana</span>
                            <span class="font-semibold text-slate-700">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Tgl Kembali Aktual</span>
                            <span class="font-semibold {{ $peminjaman->tanggal_kembali_aktual ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $peminjaman->tanggal_kembali_aktual?->format('d M Y') ?? 'Belum dikembalikan' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Status</span>
                            @php
                                $statusMap = [
                                    'dipinjam' => ['bg-blue-100', 'text-blue-700', '📖 Dipinjam'],
                                    'dikembalikan' => ['bg-emerald-100', 'text-emerald-700', '✅ Dikembalikan'],
                                ];
                                $currentStatus = $peminjaman->isTerlambat() ? 'terlambat' : $peminjaman->status;
                                if ($currentStatus == 'terlambat') {
                                    $statusStyle = ['bg-red-100', 'text-red-700', '⚠️ Terlambat'];
                                } else {
                                    $statusStyle = $statusMap[$peminjaman->status] ?? ['bg-slate-100', 'text-slate-600', $peminjaman->status];
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $statusStyle[0] }} {{ $statusStyle[1] }}">
                                {{ $statusStyle[2] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Informasi Anggota --}}
                <div class="bg-slate-50 rounded-xl p-5">
                    <h4 class="font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-yellow-500"></i>
                        Informasi Anggota
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($peminjaman->anggota->nama ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $peminjaman->anggota->nama ?? '-' }}</p>
                                <p class="text-slate-400 text-sm">{{ $peminjaman->anggota->no_anggota ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Email</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->anggota->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Telepon</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->anggota->telepon ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Informasi Buku --}}
                <div class="bg-slate-50 rounded-xl p-5">
                    <h4 class="font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-book text-yellow-500"></i>
                        Informasi Buku
                    </h4>
                    <div class="space-y-3">
                        <div class="flex gap-3 pb-3 border-b border-slate-200">
                            <div class="w-16 h-20 bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($peminjaman->buku->cover ?? false)
                                    <img src="{{ asset('covers/'.$peminjaman->buku->cover) }}" alt="cover" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-book text-slate-400 text-2xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-800">{{ $peminjaman->buku->judul ?? '-' }}</p>
                                <p class="text-slate-500 text-sm">{{ $peminjaman->buku->pengarang ?? '-' }}</p>
                                <p class="text-slate-400 text-xs mt-1">Kode: {{ $peminjaman->buku->kode_buku ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Kategori</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->buku->kategori ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Penerbit</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->buku->penerbit ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Tahun Terbit</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->buku->tahun_terbit ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Informasi Tambahan --}}
                <div class="bg-slate-50 rounded-xl p-5">
                    <h4 class="font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-yellow-500"></i>
                        Informasi Tambahan
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Denda</span>
                            @if($peminjaman->denda > 0)
                                <span class="font-bold text-red-600 text-lg">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-sm text-emerald-600">Tidak ada denda</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-sm text-slate-500">Dicatat oleh</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->user->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Dibuat pada</span>
                            <span class="text-sm text-slate-700">{{ $peminjaman->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            @if($peminjaman->keterangan)
            <div class="mb-6 bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                <div class="flex items-start gap-3">
                    <i class="fas fa-sticky-note text-yellow-600 mt-0.5"></i>
                    <div>
                        <p class="font-semibold text-yellow-800 text-sm">Keterangan</p>
                        <p class="text-yellow-700 text-sm mt-1">{{ $peminjaman->keterangan }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                @if($peminjaman->status !== 'dikembalikan')
                    <button onclick="openKembalikanModal()" 
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi Pengembalian
                    </button>
                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" 
                       class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-pen"></i>
                        Edit Peminjaman
                    </a>
                @endif
                <a href="{{ route('peminjaman.index') }}" 
                   class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
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
                        <p class="text-slate-400 text-sm">Kode: {{ $peminjaman->kode_pinjam }}</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('peminjaman.kembalikan', $peminjaman) }}" class="p-6">
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
                    @if($peminjaman->isTerlambat())
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            Terlambat {{ now()->diffInDays($peminjaman->tanggal_kembali_rencana) }} hari
                        </p>
                    @endif
                </div>
                <div>
                    <label class="form-label flex items-center gap-2">
                        <i class="fas fa-sticky-note text-emerald-500 text-xs"></i>
                        Keterangan
                    </label>
                    <textarea name="keterangan" 
                              rows="3" 
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition" 
                              placeholder="Kondisi buku, catatan pengembalian..."></textarea>
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
                    <i class="fas fa-check"></i> Konfirmasi
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
function openKembalikanModal() {
    document.getElementById('kembalikan-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('kembalikan-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('kembalikan-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
@endsection