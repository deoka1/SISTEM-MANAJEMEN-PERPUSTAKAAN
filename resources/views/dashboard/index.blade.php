@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . '!')

@section('content')
{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    <x-stats-card title="Total Buku" :value="number_format($totalBuku)" icon="fa-book" color="primary" subtitle="{{ $bukuTersedia }} buku tersedia" />
    <x-stats-card title="Total Anggota" :value="number_format($totalAnggota)" icon="fa-users" color="emerald" subtitle="{{ $anggotaAktif }} anggota aktif" />
    <x-stats-card title="Sedang Dipinjam" :value="number_format($totalPinjam)" icon="fa-book-bookmark" color="amber" subtitle="buku aktif dipinjam" />
    <x-stats-card title="Terlambat" :value="number_format($totalTerlambat)" icon="fa-clock" color="red" subtitle="perlu tindakan segera" />
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Peminjaman Terbaru --}}
    <div class="xl:col-span-2 card p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-slate-800">Peminjaman Terbaru</h3>
                <p class="text-slate-400 text-xs mt-0.5">5 transaksi terakhir</p>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="btn-secondary text-xs">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($peminjamanTerbaru->isEmpty())
            <div class="text-center py-10 text-slate-400">
                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                <p class="text-sm">Belum ada data peminjaman</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($peminjamanTerbaru as $p)
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-primary-600 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $p->buku->judul ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ $p->anggota->nama ?? '-' }} &bull; {{ $p->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                    <x-badge :status="$p->isTerlambat() ? 'terlambat' : $p->status" />
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Buku Terpopuler --}}
    <div class="card p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-800">Buku Terpopuler</h3>
            <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jumlah peminjaman</p>
        </div>

        @if($bukuTerpopuler->isEmpty())
            <div class="text-center py-10 text-slate-400">
                <i class="fas fa-chart-bar text-4xl mb-3 block"></i>
                <p class="text-sm">Belum ada data</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bukuTerpopuler as $i => $b)
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-400 w-5 text-center">{{ $i + 1 }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $b->judul }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="flex-1 bg-slate-100 rounded-full h-1.5">
                                @php $max = $bukuTerpopuler->first()->peminjaman_count ?: 1; @endphp
                                <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ ($b->peminjaman_count / $max) * 100 }}%"></div>
                            </div>
                            <span class="text-xs text-slate-400 flex-shrink-0">{{ $b->peminjaman_count }}x</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
