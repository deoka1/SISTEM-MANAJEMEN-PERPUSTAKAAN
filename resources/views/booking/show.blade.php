@extends('layouts.master')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('page-subtitle', $booking->kode_booking)

@section('content')
<div class="max-w-2xl space-y-5">

    {{-- Status --}}
    @php
    $statusConfig = [
        'menunggu'  => ['bg' => 'bg-amber-50 border-amber-200 text-amber-800', 'icon' => 'fa-clock text-amber-500'],
        'disetujui' => ['bg' => 'bg-emerald-50 border-emerald-200 text-emerald-800', 'icon' => 'fa-circle-check text-emerald-500'],
        'ditolak'   => ['bg' => 'bg-red-50 border-red-200 text-red-800', 'icon' => 'fa-circle-xmark text-red-500'],
        'selesai'   => ['bg' => 'bg-slate-50 border-slate-200 text-slate-700', 'icon' => 'fa-circle-check text-slate-400'],
    ];
    $sc = $statusConfig[$booking->status] ?? $statusConfig['menunggu'];
    @endphp

    <div class="border rounded-2xl {{ $sc['bg'] }} p-5 flex items-center gap-3">
        <i class="fas {{ $sc['icon'] }} text-2xl"></i>
        <div>
            <p class="font-bold">{{ $booking->statusLabel() }}</p>
            @if($booking->alasan_penolakan)
                <p class="text-sm mt-0.5">Alasan: {{ $booking->alasan_penolakan }}</p>
            @endif
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="card p-6 space-y-5">
        {{-- Buku --}}
        <div class="flex gap-4 pb-5 border-b border-slate-100">
            <div class="w-14 h-18 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                @if($booking->buku->cover && file_exists(public_path('covers/'.$booking->buku->cover)))
                    <img src="{{ asset('covers/'.$booking->buku->cover) }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-book text-primary-400 text-xl"></i>
                @endif
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Buku yang Dipesan</p>
                <p class="font-bold text-slate-800">{{ $booking->buku->judul }}</p>
                <p class="text-slate-500 text-sm">{{ $booking->buku->pengarang }}</p>
                <span class="font-mono text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded mt-1 inline-block">{{ $booking->buku->kode_buku }}</span>
            </div>
        </div>

        {{-- Peminjam --}}
        <div class="grid grid-cols-2 gap-4 text-sm">
            @foreach([
                ['Kode Booking', $booking->kode_booking, true],
                ['No. Anggota', $booking->no_anggota, true],
                ['Nama Peminjam', $booking->nama_peminjam, false],
                ['Email', $booking->email_peminjam, false],
                ['Telepon', $booking->telepon_peminjam ?? '-', false],
                ['Tgl Booking', $booking->tanggal_booking->format('d M Y'), false],
                ['Rencana Ambil', $booking->tanggal_pinjam_rencana->format('d M Y'), false],
                ['Rencana Kembali', $booking->tanggal_kembali_rencana->format('d M Y'), false],
            ] as [$label, $value, $mono])
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">{{ $label }}</p>
                @if($mono)
                    <span class="font-mono bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-sm">{{ $value }}</span>
                @else
                    <p class="font-semibold text-slate-800">{{ $value }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @if($booking->catatan)
        <div class="pt-4 border-t border-slate-100">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Catatan Pelanggan</p>
            <p class="text-slate-700 text-sm">{{ $booking->catatan }}</p>
        </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="card p-5 flex flex-wrap gap-3">
        @if($booking->status === 'menunggu')
        <form method="POST" action="{{ route('booking.setujui', $booking) }}">
            @csrf
            <button type="submit" class="btn-success">
                <i class="fas fa-check"></i> Setujui Booking
            </button>
        </form>
        <button onclick="document.getElementById('tolak-inline').classList.toggle('hidden')" class="btn-danger">
            <i class="fas fa-xmark"></i> Tolak Booking
        </button>
        @endif

        @if($booking->status === 'disetujui')
        <form method="POST" action="{{ route('booking.selesai', $booking) }}" onsubmit="return confirm('Buat data peminjaman dari booking ini?')">
            @csrf
            <button type="submit" class="btn-primary">
                <i class="fas fa-flag-checkered"></i> Tandai Selesai & Buat Peminjaman
            </button>
        </form>
        @endif

        <a href="{{ route('booking.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Tolak inline form --}}
    @if($booking->status === 'menunggu')
    <div id="tolak-inline" class="hidden card p-6">
        <h4 class="font-bold text-slate-700 mb-3">Alasan Penolakan</h4>
        <form method="POST" action="{{ route('booking.tolak', $booking) }}" class="space-y-3">
            @csrf
            <textarea name="alasan_penolakan" rows="3" class="form-input" placeholder="Jelaskan alasan penolakan..." required></textarea>
            <div class="flex gap-2">
                <button type="submit" class="btn-danger"><i class="fas fa-xmark"></i> Konfirmasi Tolak</button>
                <button type="button" onclick="document.getElementById('tolak-inline').classList.add('hidden')" class="btn-secondary">Batal</button>
            </div>
        </form>
    </div>
    @endif

</div>
@endsection
